<?php
declare(strict_types = 1);

/*
 * This file is part of the package t3g/blog.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace T3G\AgencyPack\Blog\Utility;

class ArchiveUtility
{
    /**
     * This method extracts and sorts the database result and create a nested array
     * in the form:
     * [
     *  2015 => [
     *    [
     *      'year' => 2015,
     *      'month' => 3,
     *      'count' => 9
     *      'timestamp' => 123456789
     *    ]
     *    ...
     *  ]
     *  ...
     * ]
     *
     * @param array $data
     * @return array
     * @throws \Exception
     */
    public static function extractDataFromPosts(array $data): array
    {
        $archiveData = [];
        foreach ($data as $result) {
            if (($archiveData[$result['year'] ?? null] ?? null) === null) {
                $archiveData[$result['year']] = [];
            }
            $dateTime = new \DateTimeImmutable(sprintf('%d-%d-1', (int)($result['year'] ?? 0), (int)($result['month'] ?? 0)));
            $result['timestamp'] = $dateTime->getTimestamp();
            $archiveData[$result['year']][] = $result;
        }

        return $archiveData;
    }
}
