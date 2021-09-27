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
 * PHP version 7.4
 *
 * @category TheTVDbAPI
 * @package  CanIHaveSomeCoffee\TheTVDbAPI
 * @author   Willem Van Iseghem (canihavesomecoffee) <theTVDbAPI@canihavesome.coffee>
 * @license  See start of document
 * @link     https://canihavesome.coffee/projects/theTVDbAPI
 */
declare(strict_types = 1);

namespace CanIHaveSomeCoffee\TheTVDbAPI;

use Symfony\Component\PropertyInfo\Extractor\PhpDocExtractor;
use Symfony\Component\PropertyInfo\Extractor\ReflectionExtractor;
use Symfony\Component\PropertyInfo\PropertyInfoExtractor;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Normalizer\ArrayDenormalizer;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
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
     * @var Serializer|null
     */
    private static ?Serializer $serializer = null;


    /**
     * Parses the given JSON data into an instance of return_class.
     *
     * @param array  $json        The JSON data. Must be valid
     * @param string $returnClass The expected return class
     *
     * @return mixed
     * @throws ExceptionInterface
     */
    public static function parseData(array $json, string $returnClass)
    {
        return static::getSerializer()->denormalize($json, $returnClass);
    }

    /**
     * Parses the given JSON data into an array of return_class instances.
     *
     * @param object|array $json        The JSON data. Must be valid
     * @param string       $returnClass The expected return class
     *
     * @return array
     * @throws ExceptionInterface
     */
    public static function parseDataArray($json, string $returnClass): array
    {
        $result = [];
        if (is_array($json)) {
            foreach ($json as $entry) {
                $result[] = static::parseData($entry, $returnClass);
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
            $extractor          = new PropertyInfoExtractor([], [new PhpDocExtractor(), new ReflectionExtractor()]);
            static::$serializer = new Serializer(
                [new ArrayDenormalizer(), new DateTimeNormalizer(), new ObjectNormalizer(null, null, null, $extractor)],
                [new JsonEncoder()]
            );
        }
        return static::$serializer;
    }


}
