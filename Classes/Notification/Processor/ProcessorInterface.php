<?php
declare(strict_types = 1);

/*
 * This file is part of the package t3g/blog.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace T3G\AgencyPack\Blog\Notification\Processor;

use T3G\AgencyPack\Blog\Notification\NotificationInterface;

interface ProcessorInterface
{
    /**
     * Process the notification
     *
     * @param NotificationInterface $notification
     * @return mixed
     */
    public function process(NotificationInterface $notification);
}
