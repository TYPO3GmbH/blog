<?php

namespace T3G\AgencyPack\Blog\UserFunc;

/**
 * Class MetaService.
 */
class MetaService
{
    /**
     * @param string $content
     * @param array $conf
     *
     * @return mixed|string
     */
    public function get($content, $conf)
    {
        $key = isset($conf['key']) ? $conf['key'] : null;
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
