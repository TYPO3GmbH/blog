<?php
declare(strict_types = 1);

/*
 * This file is part of the package t3g/blog.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace T3G\AgencyPack\Blog\Notification\Processor;

use T3G\AgencyPack\Blog\Mail\MailMessage;
use T3G\AgencyPack\Blog\Notification\CommentAddedNotification;
use T3G\AgencyPack\Blog\Notification\NotificationInterface;
use TYPO3\CMS\Core\TypoScript\TypoScriptService;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController;

class AdminNotificationProcessor implements ProcessorInterface
{
    /**
     * Process the notification
     *
     * @param NotificationInterface $notification
     * @throws \InvalidArgumentException
     */
    public function process(NotificationInterface $notification)
    {
        $notificationId = $notification->getNotificationId();

        if ($notificationId === CommentAddedNotification::class) {
            $this->processCommentAddNotification($notification);
        }
    }

    /**
     * @param NotificationInterface $notification
     * @throws \InvalidArgumentException
     */
    protected function processCommentAddNotification(NotificationInterface $notification): void
    {
        $notificationId = $notification->getNotificationId();
        $settings = [];
        $frontendController = $this->getTypoScriptFrontendController();
        if ($frontendController instanceof TypoScriptFrontendController) {
            $settings = $frontendController->tmpl->setup['plugin.']['tx_blog.']['settings.'] ?? [];
            $typoScriptService = GeneralUtility::makeInstance(TypoScriptService::class);
            $settings = $typoScriptService->convertTypoScriptArrayToPlainArray($settings);
        }

        if ((int)$settings['notifications'][$notificationId]['admin']['_typoScriptNodeValue'] === 1) {
            $emailAddresses = GeneralUtility::trimExplode(',', $settings['notifications'][$notificationId]['admin']['email']);
            $mail = GeneralUtility::makeInstance(MailMessage::class);
            $mail
                ->setSubject($notification->getTitle())
                ->setBody($notification->getMessage())
                ->setFrom([$settings['notifications']['email']['senderMail'] => $settings['notifications']['email']['senderName']])
                ->setTo($emailAddresses)
                ->send();
        }
    }

    protected function getTypoScriptFrontendController(): ?TypoScriptFrontendController
    {
        return $GLOBALS['TSFE'];
    }
}
