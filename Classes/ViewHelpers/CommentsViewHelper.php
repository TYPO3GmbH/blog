<?php

namespace T3G\AgencyPack\Blog\ViewHelpers;

use T3G\AgencyPack\Blog\Service\CommentService;

class CommentsViewHelper extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper
{

    /**
     * @var \T3G\AgencyPack\Blog\Domain\Repository\PostRepository
     * @inject
     */
    protected $postRepository;

    /**
     * @var \TYPO3\CMS\Extbase\Object\ObjectManager
     * @inject
     */
    public $objectManager;
        
    /**
    * @param \T3G\AgencyPack\Blog\Domain\Model\Post $post
    * @return int Number of Comments
    */  
    public function render($post)
    {

        $configurationManager = $this->objectManager->get('TYPO3\CMS\Extbase\Configuration\ConfigurationManager');
        $settings = $configurationManager->getConfiguration(\TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface::CONFIGURATION_TYPE_SETTINGS, 'blog', 'tx_blog');
        
        return count($this->commentService->getCommentsByPost($post));
        
    }

	public function injectConfigurationManager(\TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface $configurationManager) {
		$this->configurationManager = $configurationManager;
	}    
    
    /**
     * @param \T3G\AgencyPack\Blog\Service\CommentService $commentService
     */
    public function injectCommentService(CommentService $commentService)
    {
        $this->commentService = $commentService;
    }    
    
}