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
use T3G\AgencyPack\Blog\Domain\Repository\PostRepository;
use T3G\TemplateTypo3com\Service\LanguageService;
use TYPO3\CMS\Backend\Module\AbstractModule;
use TYPO3\CMS\Core\Resource\ResourceFactory;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Utility\StringUtility;
use TYPO3\CMS\Extbase\Object\ObjectManager;
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;
use TYPO3\CMS\Fluid\View\StandaloneView;
use TYPO3\CMS\Lang\Service\TranslationService;

/**
 * Class SocialImageWizardController
 *
 * @package T3G\AgencyPack\Blog\Form\Wizards
 */
class SocialImageWizardController extends AbstractModule
{

    /**
     * @var StandaloneView
     */
    protected $view;

    /**
     * SocialImageWizardController constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->view = GeneralUtility::makeInstance(StandaloneView::class);
        $this->view->setTemplatePathAndFilename('EXT:blog/Resources/Private/Templates/Backend/SocialImageWizard.html');

    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @return ResponseInterface
     */
    public function indexAction(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $postData = $this->getPageData();
        $this->view->assign('postData', $postData);

        $markup = '
        <style>
            
        </style>

        ';

        $this->moduleTemplate->setContent($this->view->render());
        $this->moduleTemplate->getPageRenderer()->addCssFile('EXT:blog/Resources/Public/Css/SocialImageWizard.css');
        $this->moduleTemplate->getPageRenderer()->loadJquery();
        $this->moduleTemplate->getPageRenderer()->addJsFile('EXT:blog/Resources/Public/JavaScript/fabric.min.js');
        $this->moduleTemplate->getPageRenderer()->addJsFile('EXT:blog/Resources/Public/JavaScript/SocialImageApp.js');



        $response->getBody()->write($this->moduleTemplate->renderContent());
        return $response;
    }

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
                $result['fields'] = $this->getFalFields($parsedBody['table'], $parsedBody['uid']);
            }
        }

        $response->getBody()->write(json_encode($result));
        return $response;
    }

    /**
     * @return array
     */
    protected function getFalFields($table, $uid)
    {
        $result = [];

        foreach ($GLOBALS['TCA'][$table]['columns'] as $column => $configuration) {
            if (!empty($configuration['config']['type'])
                && $configuration['config']['type'] === 'inline'
                && !empty($configuration['config']['foreign_table'])
                && $configuration['config']['foreign_table'] === 'sys_file_reference'
            ) {
                $result[] = ['identifier' => $column, 'label' => LocalizationUtility::translate($configuration['label'])];
            }
        }
        return $result;
    }

    /**
     * @return array
     * @throws \InvalidArgumentException
     */
    protected function getPageData(): array
    {
        $post = GeneralUtility::makeInstance(ObjectManager::class)
            ->get(PostRepository::class)
            ->findCurrentPost();

        $socialData = [
            'author' => $post->getAuthors()->current()->getName(),
            'image' => $post->getMedia()->current()->getOriginalResource()->getPublicUrl(),
            'title' => $post->getTitle(),
            'uid' => $post->getUid(),
            'table' => 'pages'
        ];

        return $socialData;
    }
}
