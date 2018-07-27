<?php

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

/**
 * Interface NotificationInterface
 */
interface NotificationInterface
{
    /**
     * @return string
     */
    public function getNotificationId(): string;

    /**
     * Get the title of the message
     *
     * @return string
     */
    public function getTitle(): string;

    /**
     * Get the message of the notification
     *
     * @return string
     */
    public function getMessage(): string;

    /**
     * Get additional data of notification
     *
     * @return array
     */
    public function getData(): array;
}
