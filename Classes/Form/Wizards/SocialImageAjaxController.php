<?php

namespace T3G\AgencyPack\Blog\Form\Wizards;

/*
 * This file is part of the TYPO3 CMS project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use TYPO3\CMS\Backend\Form\FormDataCompiler;
use TYPO3\CMS\Backend\Form\FormDataGroup\TcaDatabaseRecord;
use TYPO3\CMS\Core\Resource\FileReference;
use TYPO3\CMS\Core\Resource\FileRepository;
use TYPO3\CMS\Core\Resource\ResourceFactory;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Utility\StringUtility;
use TYPO3\CMS\Extbase\Object\ObjectManager;
use TYPO3\CMS\Extbase\Service\ImageService;
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;

/**
 * Class SocialImageAjaxController
 *
 * @package T3G\AgencyPack\Blog\Form\Wizards
 */
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
                $newFile = $storage->addFile(
                    $tempFileName,
                    $storage->getRootLevelFolder(),
                    $fileName
                );
                $result['status'] = 'ok';
                $result['message'] = 'the file has been saved successfully';
                $result['file'] = $newFile->getPublicUrl();
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
        if (count($fileObjects)) {
            foreach ($fileObjects as $fileObject) {
                $results[] = [
                    'referenceId' => $fileObject->getUid(),
                    'title' => !empty($fileObject->getTitle()) ? $fileObject->getTitle() : $fileObject->getName(),
                    'thumb' => $this->createThumbnail($fileObject),
                ];
            }
        }
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
        $image = $this->imageService->getImage($fileReference->getPublicUrl(), null, false);
        $processingInstructions = array(
            'maxWidth' => 400,
            'maxHeight' => 200,
        );

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
}
