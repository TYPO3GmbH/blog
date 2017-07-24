<?php

namespace T3G\AgencyPack\Blog\Service;

/**
 * Class MetaService.
 */
class MetaService extends \ArrayObject
{
    // Used for the <title>-Tag or meta title tags
    const META_TITLE = 'title';

    // <meta>-Description tag
    const META_DESCRIPTION = 'description';

    // Creation date
    const META_PUBLISHED_DATE = 'published_date';

    // Last modified date (field: tstamp)
    const META_MODIFIED_DATE = 'modified_date';

    // Overwrite the canonical URL
    const META_URL = 'url';

    // The tags of the blog post
    const META_TAGS = 'tags';

    // The categories of the blog post
    const META_CATEGORIES = 'categories';

    /**
     * Registry object provides storage for shared objects.
     *
     * @var MetaService
     */
    private static $instance;

    /**
     * Retrieves the default registry instance.
     *
     * @return MetaService
     *
     * @throws \RuntimeException
     */
    public static function getInstance() : MetaService
    {
        if (self::$instance === null) {
            self::init();
        }

        return self::$instance;
    }

    /**
     * Set the default registry instance to a specified instance.
     *
     * @param MetaService $instance An object instance of type Registry,
     *                              or a subclass.
     * @param MetaService $instance
     *
     * @throws \RuntimeException
     */
    public static function setInstance(MetaService $instance)
    {
        if (self::$instance !== null) {
            throw new \RuntimeException('Registry is already initialized', 1398536572);
        }
        self::$instance = $instance;
    }

    /**
     * Initialize the default registry instance.
     *
     * @throws \RuntimeException
     */
    protected static function init()
    {
        self::setInstance(new self());
    }

    /**
     * getter method, basically same as offsetGet().
     *
     * This method can be called from an object of type Registry, or it
     * can be called statically.  In the latter case, it uses the default
     * static instance stored in the class.
     *
     * @param string $index - get the value associated with $index
     *
     * @return mixed
     *
     * @throws \RuntimeException if no entry is registerd for $index.
     */
    public static function get($index)
    {
        $instance = self::getInstance();
        if (!$instance->offsetExists($index)) {
            throw new \RuntimeException('No entry is registered for key \''.$index.'\'', 1398536594);
        }

        return $instance->offsetGet($index);
    }

    /**
     * setter method, basically same as offsetSet().
     *
     * This method can be called from an object of type Registry, or it
     * can be called statically.  In the latter case, it uses the default
     * static instance stored in the class.
     *
     * @param string $index The location in the ArrayObject in which to store
     *                      the value.
     * @param mixed  $value The object to store in the ArrayObject.
     *
     * @throws \RuntimeException
     */
    public static function set($index, $value)
    {
        $instance = self::getInstance();
        $instance->offsetSet($index, $value);
    }

    /**
     * Returns TRUE if the $index is a named value in the registry,
     * or FALSE if $index was not found in the registry.
     *
     * @param string $index
     *
     * @return bool
     */
    public static function isRegistered($index) : bool
    {
        if (self::$instance === null) {
            return false;
        }

        return self::$instance->offsetExists($index);
    }

    /**
     * method to check if offset exists.
     *
     * @param string $index
     *
     * @returns mixed
     *
     * Workaround for http://bugs.php.net/bug.php?id=40442 (ZF-960).
     */
    public function offsetExists($index)
    {
        return array_key_exists($index, $this);
    }
}
