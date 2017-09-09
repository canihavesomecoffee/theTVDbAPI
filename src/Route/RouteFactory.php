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
 *
 * Factory to generate route objects.
 *
 * PHP version 7.1
 *
 * @category TheTVDbAPI
 * @package  CanIHaveSomeCoffee\TheTVDbAPI\Route
 * @author   Willem Van Iseghem (canihavesomecoffee) <theTVDbAPI@canihavesome.coffee>
 * @license  See start of document
 * @link     https://canihavesome.coffee/projects/theTVDbAPI
 */
declare(strict_types = 1);

namespace CanIHaveSomeCoffee\TheTVDbAPI\Route;

use CanIHaveSomeCoffee\TheTVDbAPI\TheTVDbAPIInterface;
use InvalidArgumentException;

/**
 * Class RouteFactory
 *
 * @category TheTVDbAPI
 * @package  CanIHaveSomeCoffee\TheTVDbAPI\Route
 * @author   Willem Van Iseghem (canihavesomecoffee) <theTVDbAPI@canihavesome.coffee>
 * @license  See start of document
 * @link     https://canihavesome.coffee/projects/theTVDbAPI
 */
class RouteFactory
{
    /**
     * Array holding actual instances of route objects.
     *
     * @var array
     */
    private static $routeInstances = [];


    /**
     * Retrieves an instance of the given routeClassName.
     *
     * @param TheTVDbAPIInterface $parent         The parent object that is needed for constructing a new object.
     * @param string              $routeClassName The name of the instance to retrieve.
     *
     * @return mixed The requested instance
     * @throws InvalidArgumentException If the given class name does not implement the RouteInterface
     */
    public static function getRouteInstance(TheTVDbAPIInterface $parent, string $routeClassName)
    {
        if (array_key_exists($routeClassName, static::$routeInstances) === false) {
            $class_implements = class_implements($routeClassName);
            if (in_array('CanIHaveSomeCoffee\TheTVDbAPI\Route\RouteInterface', $class_implements) === false) {
                throw new InvalidArgumentException('Class does not implement the RouteInterface!');
            }
            $args = [$parent];
            static::$routeInstances[$routeClassName] = new $routeClassName(...$args);
        }
        return static::$routeInstances[$routeClassName];
    }
}
