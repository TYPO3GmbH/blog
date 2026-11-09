<?php
declare(strict_types = 1);

/*
 * This file is part of the package t3g/blog.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace T3G\AgencyPack\Blog\Domain\Finisher;

use T3G\AgencyPack\Blog\Domain\Model\Comment;
use T3G\AgencyPack\Blog\Domain\Repository\PostRepository;
use T3G\AgencyPack\Blog\Notification\CommentAddedNotification;
use T3G\AgencyPack\Blog\Notification\NotificationManager;
use T3G\AgencyPack\Blog\Service\CacheService;
use T3G\AgencyPack\Blog\Service\CommentService;
use TYPO3\CMS\Core\Messaging\FlashMessage;
use TYPO3\CMS\Core\Messaging\FlashMessageService;
use TYPO3\CMS\Core\Type\ContextualFeedbackSeverity;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface;
use TYPO3\CMS\Extbase\Service\ExtensionService;
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;
use TYPO3\CMS\Form\Domain\Finishers\AbstractFinisher;

/**
 * This finisher redirects to another Controller.
 *
 * Scope: frontend
 */
class CommentFormFinisher extends AbstractFinisher
{
    protected static array $messages = [
        CommentService::STATE_ERROR => [
            'title' => 'message.addComment.error.title',
            'text' => 'message.addComment.error.text',
            'severity' => ContextualFeedbackSeverity::ERROR,
        ],
        CommentService::STATE_MODERATION => [
            'title' => 'message.addComment.moderation.title',
            'text' => 'message.addComment.moderation.text',
            'severity' => ContextualFeedbackSeverity::INFO,
        ],
        CommentService::STATE_SUCCESS => [
            'title' => 'message.addComment.success.title',
            'text' => 'message.addComment.success.text',
            'severity' => ContextualFeedbackSeverity::OK,
        ],
    ];

    protected function executeInternal()
    {
        $settings = GeneralUtility::makeInstance(ConfigurationManagerInterface::class)
            ->getConfiguration(ConfigurationManagerInterface::CONFIGURATION_TYPE_SETTINGS, 'blog');
        $postRepository = GeneralUtility::makeInstance(PostRepository::class);
        $cacheService = GeneralUtility::makeInstance(CacheService::class);
        $commentService = GeneralUtility::makeInstance(CommentService::class);
        $commentService->setSettings($settings['comments']);

        // Create Comment
        $values = $this->finisherContext->getFormValues();
        $comment = new Comment();
        $comment->setName($values['name'] ?? '');
        $comment->setEmail($values['email'] ?? '');
        $comment->setUrl($values['url'] ?? '');
        $comment->setComment($values['comment'] ?? '');
        $post = $postRepository->findCurrentPost();
        if ($post === null) {
            return null;
        }
        $state = $commentService->addComment($post, $comment);

        // Add FlashMessage
        $pluginNamespace = GeneralUtility::makeInstance(ExtensionService::class)->getPluginNamespace(
            $this->finisherContext->getRequest()->getControllerExtensionName(),
            $this->finisherContext->getRequest()->getPluginName()
        );
        $flashMessage = GeneralUtility::makeInstance(
            FlashMessage::class,
            LocalizationUtility::translate(self::$messages[$state]['text'], 'blog'),
            LocalizationUtility::translate(self::$messages[$state]['title'], 'blog'),
            self::$messages[$state]['severity'],
            true
        );
        $flashMessageService = GeneralUtility::makeInstance(FlashMessageService::class);
        $flashMessageService
            ->getMessageQueueByIdentifier('extbase.flashmessages.' . $pluginNamespace)
            ->addMessage($flashMessage);

        if ($state !== CommentService::STATE_ERROR) {
            $comment->setCrdate(new \DateTime());
            GeneralUtility::makeInstance(NotificationManager::class)
                ->notify(
                    $this->finisherContext->getRequest(),
                    GeneralUtility::makeInstance(CommentAddedNotification::class, '', '', [
                        'comment' => $comment,
                        'post' => $post,
                    ])
                );
            $cacheService->flushCacheByTag('tx_blog_post_' . $post->getUid());
        }

        return null;
    }
}
