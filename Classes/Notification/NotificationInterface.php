<?php
declare(strict_types = 1);

/*
 * This file is part of the package t3g/blog.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace T3G\AgencyPack\Blog\Notification;

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
