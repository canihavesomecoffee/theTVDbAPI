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
 * Class that processes json and converts it into class representations.
 *
 * PHP version 7.1
 *
 * @category TheTVDbAPI
 * @package  CanIHaveSomeCoffee\TheTVDbAPI
 * @author   Willem Van Iseghem (canihavesomecoffee) <theTVDbAPI@canihavesome.coffee>
 * @license  See start of document
 * @link     https://canihavesome.coffee/projects/theTVDbAPI
 */
declare(strict_types = 1);

namespace CanIHaveSomeCoffee\TheTVDbAPI;

use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

/**
 * Class DataParser
 *
 * @category TheTVDbAPI
 * @package  CanIHaveSomeCoffee\TheTVDbAPI
 * @author   Willem Van Iseghem (canihavesomecoffee) <theTVDbAPI@canihavesome.coffee>
 * @license  See start of document
 * @link     https://canihavesome.coffee/projects/theTVDbAPI
 */
class DataParser
{
    /**
     * The Serializer instance.
     *
     * @var Serializer
     */
    private static $serializer;


    /**
     * Parses the given JSON data into an instance of return_class.
     *
     * @param array  $json         The JSON data. Must be valid
     * @param string $return_class The expected return class
     *
     * @return mixed
     */
    public static function parseData(array $json, string $return_class)
    {
        return static::getSerializer()->denormalize($json, $return_class);
    }

    /**
     * Parses the given JSON data into an array of return_class instances.
     *
     * @param object $json         The JSON data. Must be valid
     * @param string $return_class The expected return class
     *
     * @return array
     */
    public static function parseDataArray($json, string $return_class): array
    {
        $result = [];
        if (is_array($json)) {
            foreach ($json as $result_entry) {
                $result[] = static::parseData($result_entry, $return_class);
            }
        }
        return $result;
    }

    /**
     * Gets the serializer instance.
     *
     * @return Serializer An instance of the Serializer.
     */
    private static function getSerializer(): Serializer
    {
        if (static::$serializer === null) {
            static::$serializer = new Serializer([new ObjectNormalizer()], [new JsonEncoder()]);
        }
        return static::$serializer;
    }
}
