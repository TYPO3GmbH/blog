<?php
declare(strict_types = 1);

/*
 * This file is part of the package t3g/blog.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace T3G\AgencyPack\Blog\Notification;

use Psr\Http\Message\ServerRequestInterface;
use T3G\AgencyPack\Blog\Notification\Processor\ProcessorInterface;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class NotificationManager
{
    protected array $visitorsRegistry = [];

    public function __construct()
    {
        $notificationRegistry = $GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['Blog']['notificationRegistry'] ?? [];
        foreach ($notificationRegistry as $notificationId => $visitorClassNames) {
            if (!\is_array($this->visitorsRegistry[$notificationId] ?? null)) {
                $this->visitorsRegistry[$notificationId] = [];
            }
            foreach ($visitorClassNames as $visitorClassName) {
                $this->visitorsRegistry[$notificationId][] = $visitorClassName;
            }
        }
    }

    public function notify(ServerRequestInterface $request, NotificationInterface $notification): void
    {
        $notificationId = $notification->getNotificationId();
        if (\is_array($this->visitorsRegistry[$notificationId] ?? null)) {
            foreach ($this->visitorsRegistry[$notificationId] as $visitorClassName) {
                /** @var class-string<object> $visitorClassName */
                $instance = GeneralUtility::makeInstance($visitorClassName);
                if ($instance instanceof ProcessorInterface) {
                    $instance->process($request, $notification);
                }
            }
        }
    }
}
