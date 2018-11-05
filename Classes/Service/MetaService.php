<?php
declare(strict_types = 1);

/*
 * This file is part of the package t3g/blog.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace T3G\AgencyPack\Blog\Service;

/**
 * Class MetaService.
 */
class MetaService extends \ArrayObject
{
    // Used for the <title>-Tag or meta title tags
    public const META_TITLE = 'title';

    // <meta>-Description tag
    public const META_DESCRIPTION = 'description';

    // Creation date
    public const META_PUBLISHED_DATE = 'published_date';

    // Last modified date (field: tstamp)
    public const META_MODIFIED_DATE = 'modified_date';

    // Overwrite the canonical URL
    public const META_URL = 'url';

    // The tags of the blog post
    public const META_TAGS = 'tags';

    // The categories of the blog post
    public const META_CATEGORIES = 'categories';

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
    public static function getInstance() : self
    {
        if (self::$instance === null) {
            self::init();
        }

        return self::$instance;
    }

    /**
     * Set the default registry instance to a specified instance.
     *
     * @param self $instance
     */
    public static function setInstance(self $instance): void
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
    protected static function init(): void
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
            throw new \RuntimeException('No entry is registered for key \'' . $index . '\'', 1398536594);
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
    public static function set($index, $value): void
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
     * Method to check if offset exists.
     * Workaround for http://bugs.php.net/bug.php?id=40442 (ZF-960).
     *
     * @param mixed $index
     * @return bool
     */
    public function offsetExists($index): bool
    {
        return array_key_exists($index, $this);
    }
}
