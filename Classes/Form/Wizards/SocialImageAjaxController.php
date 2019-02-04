<?php
declare(strict_types = 1);

/*
 * This file is part of the package t3g/blog.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace T3G\AgencyPack\Blog\Form\Wizards;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use TYPO3\CMS\Backend\Form\FormDataCompiler;
use TYPO3\CMS\Backend\Form\FormDataGroup\TcaDatabaseRecord;
use TYPO3\CMS\Backend\Utility\BackendUtility;
use TYPO3\CMS\Core\DataHandling\DataHandler;
use TYPO3\CMS\Core\Resource\File;
use TYPO3\CMS\Core\Resource\FileReference;
use TYPO3\CMS\Core\Resource\FileRepository;
use TYPO3\CMS\Core\Resource\ResourceFactory;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Utility\StringUtility;
use TYPO3\CMS\Extbase\Object\ObjectManager;
use TYPO3\CMS\Extbase\Service\ImageService;

class SocialImageAjaxController
{
    /**
     * @var ImageService
     */
    protected $imageService;

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     *
     * @return ResponseInterface
     * @throws \TYPO3\CMS\Core\Resource\Exception\ExistingTargetFileNameException
     * @throws \InvalidArgumentException
     * @throws \RuntimeException
     */
    public function saveImageAction(ServerRequestInterface $request, ResponseInterface $response) : ResponseInterface
    {
        $parsedBody = $request->getParsedBody();
        $imageData = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $parsedBody['data']));
        $fileName = $parsedBody['name'];

        $result = [];
        $result['status'] = 'error';
        $result['message'] = 'something went wrong';
        if (!StringUtility::endsWith($fileName, '.png')) {
            $result['status'] = 'error';
            $result['message'] = 'only PNG files are allowed!';
        } else {
            $resourceFactory = ResourceFactory::getInstance();
            $storage = $resourceFactory->getDefaultStorage();
            $tempFileName = PATH_site . 'typo3temp/' . uniqid('', true);
            if ($storage !== null && GeneralUtility::writeFileToTypo3tempDir($tempFileName, $imageData) === null) {
                /** @var File $newFile */
                $newFile = $storage->addFile(
                    $tempFileName,
                    $storage->getRootLevelFolder(),
                    $fileName
                );
                $result['status'] = 'ok';
                $result['message'] = 'the file has been saved successfully';
                $result['file'] = $newFile->getPublicUrl();
                $result['fileUid'] = $newFile->getUid();
                $result['fileIdentifier'] = $newFile->getIdentifier();
                $result['fields'] = $this->getFalFields($parsedBody['table'], (int)$parsedBody['uid']);
            }
        }

        $response->getBody()->write(json_encode($result));
        return $response;
    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     *
     * @return ResponseInterface
     * @throws \TYPO3\CMS\Core\Resource\Exception\FileDoesNotExistException
     * @throws \RuntimeException
     * @throws \UnexpectedValueException
     * @throws \InvalidArgumentException
     */
    public function existingRelationsAction(ServerRequestInterface $request, ResponseInterface $response) : ResponseInterface
    {
        $parsedBody = $request->getParsedBody();

        /** @var FileReference[] $fileObjects */
        $fileObjects = GeneralUtility::makeInstance(FileRepository::class)
            ->findByRelation($parsedBody['table'], $parsedBody['field'], $parsedBody['uid']);
        $results = [];
        if (\count($fileObjects)) {
            foreach ($fileObjects as $fileObject) {
                $results[] = [
                    'referenceId' => $fileObject->getUid(),
                    'title' => !empty($fileObject->getTitle()) ? $fileObject->getTitle() : $fileObject->getName(),
                    'thumb' => $this->createThumbnail($fileObject),
                ];
            }
        } else {
            $this->createFalRelation($parsedBody);
        }
        $response->getBody()->write(json_encode($results));
        return $response;
    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     *
     * @return ResponseInterface
     * @throws \RuntimeException
     * @throws \TYPO3\CMS\Core\Resource\Exception\FileDoesNotExistException
     * @throws \InvalidArgumentException
     */
    public function replaceRelationAction(ServerRequestInterface $request, ResponseInterface $response) : ResponseInterface
    {
        $parsedBody = $request->getParsedBody();

        $data = [];
        $cmd = [];
        $cmd['sys_file_reference'][(int)$parsedBody['reference']]['delete'] = 1;

        $dataHandler = GeneralUtility::makeInstance(DataHandler::class);
        $dataHandler->start($data, $cmd);
        $dataHandler->process_cmdmap();

        $results = $this->createFalRelation($parsedBody);
        $response->getBody()->write(json_encode($results));
        return $response;
    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     *
     * @return ResponseInterface
     * @throws \RuntimeException
     * @throws \TYPO3\CMS\Core\Resource\Exception\FileDoesNotExistException
     * @throws \InvalidArgumentException
     */
    public function insertAfterRelationAction(ServerRequestInterface $request, ResponseInterface $response) : ResponseInterface
    {
        $parsedBody = $request->getParsedBody();
        $results = $this->createFalRelation($parsedBody);
        $response->getBody()->write(json_encode($results));
        return $response;
    }

    /**
     * @param FileReference $fileReference
     *
     * @return string
     * @throws \UnexpectedValueException
     * @throws \InvalidArgumentException
     */
    protected function createThumbnail(FileReference $fileReference) : string
    {
        if ($this->imageService === null) {
            $this->imageService = GeneralUtility::makeInstance(ObjectManager::class)
                ->get(ImageService::class);
        }
        $image = $this->imageService->getImage((string)$fileReference->getPublicUrl(), null, false);
        $processingInstructions = [
            'maxWidth' => 400,
            'maxHeight' => 200,
        ];

        return $this->imageService->getImageUri(
            $this->imageService->applyProcessingInstructions($image, $processingInstructions)
        );
    }

    /**
     * @param string $table
     *
     * @param int $uid
     *
     * @return array
     * @throws \UnexpectedValueException
     * @throws \InvalidArgumentException
     */
    protected function getFalFields(string $table, int $uid) : array
    {
        $result = [];
        $formDataCompiler = GeneralUtility::makeInstance(
            FormDataCompiler::class,
            GeneralUtility::makeInstance(TcaDatabaseRecord::class)
        );
        $formData = $formDataCompiler->compile([
            'tableName' => $table,
            'vanillaUid' => $uid,
            'command' => 'edit'
        ]);

        if (!empty($formData['processedTca']['columns'])) {
            foreach ($formData['processedTca']['columns'] as $column => $configuration) {
                if (!empty($configuration['config']['type'])
                    && $configuration['config']['type'] === 'inline'
                    && !empty($configuration['config']['foreign_table'])
                    && $configuration['config']['foreign_table'] === 'sys_file_reference'
                ) {
                    $result[] = ['identifier' => $column, 'label' => $configuration['label']];
                }
            }
        }
        return $result;
    }

    /**
     * @param $parsedBody
     *
     * @return array
     * @throws \TYPO3\CMS\Core\Resource\Exception\FileDoesNotExistException
     * @throws \InvalidArgumentException
     */
    protected function createFalRelation($parsedBody) : array
    {
        $fileObject = ResourceFactory::getInstance()
            ->getFileObject((int)$parsedBody['file']);

        $record = BackendUtility::getRecord(
            $parsedBody['table'],
            (int)$parsedBody['uid']
        );

        $newId = uniqid('NEW', true);
        $data = [];
        $data['sys_file_reference'][$newId] = [
            'table_local' => 'sys_file',
            'uid_local' => $fileObject->getUid(),
            'tablenames' => $parsedBody['table'],
            'uid_foreign' => (int)$parsedBody['uid'],
            'fieldname' => $parsedBody['field'],
            'pid' => $record['pid']
        ];
        $data[$parsedBody['table']][$record['uid']] = [
            $parsedBody['field'] => $newId
        ];

        $dataHandler = GeneralUtility::makeInstance(DataHandler::class);
        $dataHandler->start($data, []);
        $dataHandler->process_datamap();

        $results = [];
        $results['status'] = \count($dataHandler->errorLog) === 0 ? 'ok' : 'error';
        return $results;
    }
}
