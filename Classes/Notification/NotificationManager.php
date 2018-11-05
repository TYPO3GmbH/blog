<?php
declare(strict_types = 1);

/*
 * This file is part of the package t3g/blog.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace T3G\AgencyPack\Blog\Notification;

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

use T3G\AgencyPack\Blog\Notification\Processor\ProcessorInterface;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Class NotificationManager
 */
class NotificationManager
{
    /**
     * @var array
     */
    protected $visitorsRegistry = [];

    public function __construct()
    {
        $notificationRegistry = $GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['Blog']['notificationRegistry'] ?? [];
        foreach ($notificationRegistry as $notificationId => $visitorClassNames) {
            if (!\is_array($this->visitorsRegistry[$notificationId])) {
                $this->visitorsRegistry[$notificationId] = [];
            }
            foreach ($visitorClassNames as $visitorClassName) {
                $this->visitorsRegistry[$notificationId][] = $visitorClassName;
            }
        }
    }

    /**
     * @param NotificationInterface $notification
     * @throws \InvalidArgumentException
     */
    public function notify(NotificationInterface $notification): void
    {
        $notificationId = $notification->getNotificationId();
        if (\is_array($this->visitorsRegistry[$notificationId])) {
            foreach ($this->visitorsRegistry[$notificationId] as $visitorClassName) {
                $instance = GeneralUtility::makeInstance($visitorClassName);
                if ($instance instanceof ProcessorInterface) {
                    $instance->process($notification);
                }
            }
        }
    }
}
