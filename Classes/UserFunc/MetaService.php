<?php
declare(strict_types = 1);

/*
 * This file is part of the package t3g/blog.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace T3G\AgencyPack\Blog\UserFunc;

/**
 * Class MetaService.
 */
class MetaService
{
    /**
     * @param string $_
     * @param array  $conf
     *
     * @return mixed|string
     */
    public function get($_, $conf)
    {
        $key = $conf['key'] ?? null;
        if ($key !== null) {
            try {
                return \T3G\AgencyPack\Blog\Service\MetaService::get($key);
            } catch (\RuntimeException $e) {
                if ($e->getCode() === 1398536594) {
                    return '';
                }
            }
        }

        return '';
    }
}
