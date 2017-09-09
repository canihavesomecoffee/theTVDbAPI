<?php
/**
 * Copyright (c) 2017, Willem Van Iseghem (canihavesomecoffee) <theTVDbAPI@canihavesome.coffee>
 *
 * Permission to use, copy, modify, and/or distribute this software for any purpose with or without fee is hereby
 * granted, provided that the above copyright notice and this permission notice appear in all copies.
 *
 * THE SOFTWARE IS PROVIDED "AS IS" AND THE AUTHOR DISCLAIMS ALL WARRANTIES WITH REGARD TO THIS SOFTWARE INCLUDING ALL
 * IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS. IN NO EVENT SHALL THE AUTHOR BE LIABLE FOR ANY SPECIAL, DIRECT,
 * INDIRECT, OR CONSEQUENTIAL DAMAGES OR ANY DAMAGES WHATSOEVER RESULTING FROM LOSS OF USE, DATA OR PROFITS, WHETHER
 * IN AN ACTION OF CONTRACT, NEGLIGENCE OR OTHER TORTIOUS ACTION, ARISING OUT OF OR IN CONNECTION WITH THE USE OR
 * PERFORMANCE OF THIS SOFTWARE.
 */
declare(strict_types = 1);

namespace CanIHaveSomeCoffee\TheTVDbAPI\Tests;

use PHPUnit\Framework\TestCase;

/**
 * Class BaseUnitTest
 *
 * @category Tests
 * @package  Coffee\CanIHaveSome\Framework\Tests
 * @author   Willem Van Iseghem (canihavesomecoffee) <theTVDbAPI@canihavesome.coffee>
 * @license  See start of document
 * @link     https://canihavesome.coffee/projects/theTVDbAPI
 */
abstract class BaseUnitTest extends TestCase
{
    /**
     * Asserts that a private attribute (array type) has a given key.
     *
     * @param string $key           The key to search for in the attribute
     * @param string $attributeName The name of the attribute
     * @param mixed  $classOrObject The instance of the object to search into
     *
     * @return void
     */
    public static function assertAttributeHasKey(string $key, string $attributeName, $classOrObject)
    {
        $property = static::readAttribute($classOrObject, $attributeName);
        static::assertInternalType('array', $property);
        static::assertArrayHasKey($key, $property);
    }

    /**
     * Asserts that a private attribute (array type) does not have a given key.
     *
     * @param string $key           The key to search for in the attribute
     * @param string $attributeName The name of the attribute
     * @param mixed  $classOrObject The instance of the object to search into
     *
     * @return void
     */
    public static function assertAttributeNotHasKey(string $key, string $attributeName, $classOrObject)
    {
        $property = static::readAttribute($classOrObject, $attributeName);
        static::assertInternalType('array', $property);
        static::assertArrayNotHasKey($key, $property);
    }

    /**
     * Asserts that a private attribute (array type) has a certain object for a given key.
     *
     * @param string $key           The key to search for in the attribute
     * @param mixed  $value         The object that should be in the attribute for the key
     * @param string $attributeName The name of the attribute
     * @param mixed  $classOrObject The instance of the object to search into
     *
     * @return void
     */
    public static function assertAttributeHasKeyWithValue(string $key, $value, string $attributeName, $classOrObject)
    {
        $property = static::readAttribute($classOrObject, $attributeName);
        static::assertArrayHasKeyWithValue($key, $value, $property);
    }

    /**
     * Asserts that a private attribute (array type) does not have a value for the given key.
     *
     * @param string $key           The key to search for in the attribute
     * @param mixed  $value         The object that should not be in the attribute for the key
     * @param string $attributeName The name of the attribute
     * @param mixed  $classOrObject The instance of the object to search into
     *
     * @return void
     */
    public static function assertAttributeNotHasKeyWithValue(string $key, $value, string $attributeName, $classOrObject)
    {
        $property = static::readAttribute($classOrObject, $attributeName);
        static::assertArrayNotHasKeyWithValue($key, $value, $property);
    }

    /**
     * Asserts that an array does have a value for the given key.
     *
     * @param string $needle   The key to search for in the attribute
     * @param mixed  $value    The object that should be in the array for the key
     * @param array  $hayStack The haystack to search for
     *
     * @return void
     */
    public static function assertArrayHasKeyWithValue(string $needle, $value, array $hayStack)
    {
        static::assertInternalType('array', $hayStack);
        static::assertArrayHasKey($needle, $hayStack);
        static::assertEquals($value, $hayStack[$needle]);
    }

    /**
     * Asserts that an array does not have a value for the given key.
     *
     * @param string $needle   The key to search for in the attribute
     * @param mixed  $value    The object that should not be in the array for the key
     * @param array  $hayStack The haystack to search for
     *
     * @return void
     */
    public static function assertArrayNotHasKeyWithValue(string $needle, $value, array $hayStack)
    {
        static::assertInternalType('array', $hayStack);
        static::assertArrayHasKey($needle, $hayStack);
        static::assertNotEquals($value, $hayStack[$needle]);
    }
}
