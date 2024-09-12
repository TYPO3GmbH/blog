<?php
declare(strict_types = 1);

/*
 * This file is part of the package t3g/blog.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace T3G\AgencyPack\Blog\Tests;

use \ArrayAccess as ArrayAccess;

trait AssertionsTrait
{
    /**
     * Assert that SUT is an array of a specific length.
     *
     * Optionally, SUT is asserted to contain only elements of given type.
     *
     * @param int $count Expected array length
     * @param mixed $actual SUT
     * @param string|null $type Optional expected type of elements in SUT
     */
    protected static function assertArray(int $count, $actual, ?string $type = null): void
    {
        self::assertIsArray($actual);
        self::assertCount($count, $actual);
        if ($type) {
            self::assertContainsOnly($type, $actual);
        }
    }

    /**
     * Assert that SUT is an array of a specific length and contains only arrays.
     *
     * Optionally, SUT is asserted to have only given indices.
     *
     * @param int $count Expected array length
     * @param mixed $actual SUT
     * @param int|string|array $indices Optional expected array indices
     */
    protected static function assertArrayOfArrays(int $count, $actual, $indices = []): void
    {
        self::assertArray($count, $actual, 'array');
        if (!is_array($indices)) {
            $indices = [$indices];
        }
        foreach ($indices as $index) {
            self::assertArrayHasKey($index, $actual);
        }
    }

    /**
     * Assert that array SUT contains given key and value.
     *
     * @param int|string $key
     * @param mixed $value
     * @param array|ArrayAccess $actual
     */
    protected static function assertArrayKeyValue($key, $value, $actual): void
    {
        self::assertArrayHasKey($key, $actual);
        self::assertSame($value, $actual[$key]);
    }
}
