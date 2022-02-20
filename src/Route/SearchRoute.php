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
 * Route that exposes the search methods of TheTVDb API.
 *
 * PHP version 7.4
 *
 * @category TheTVDbAPI
 * @package  CanIHaveSomeCoffee\TheTVDbAPI\Route
 * @author   Willem Van Iseghem (canihavesomecoffee) <theTVDbAPI@canihavesome.coffee>
 * @license  See start of document
 * @link     https://canihavesome.coffee/projects/theTVDbAPI
 */
declare(strict_types = 1);

namespace CanIHaveSomeCoffee\TheTVDbAPI\Route;

use CanIHaveSomeCoffee\TheTVDbAPI\DataParser;
use CanIHaveSomeCoffee\TheTVDbAPI\Exception\ParseException;
use CanIHaveSomeCoffee\TheTVDbAPI\Exception\ResourceNotFoundException;
use CanIHaveSomeCoffee\TheTVDbAPI\Exception\UnauthorizedException;
use CanIHaveSomeCoffee\TheTVDbAPI\Model\SearchResult;
use InvalidArgumentException;
use Symfony\Component\Serializer\Exception\ExceptionInterface;

/**
 * Class SearchRoute
 *
 * @category TheTVDbAPI
 * @package  CanIHaveSomeCoffee\TheTVDbAPI\Route
 * @author   Willem Van Iseghem (canihavesomecoffee) <theTVDbAPI@canihavesome.coffee>
 * @license  See start of document
 * @link     https://canihavesome.coffee/projects/theTVDbAPI
 */
class SearchRoute extends AbstractRoute
{


    /**
     * Checks if the given key is a valid search type.
     *
     * @param string $key The key type to check.
     *
     * @return bool
     */
    public static function isValidOptionalParameter(string $key): bool
    {
        $validParameters = [
            "type",
            "year",
            "offset",
            "company",
            "country",
            "director",
            "language",
            "primaryType",
            "network",
            "remote_id",
            "limit",
        ];
        return in_array($key, $validParameters);
    }

    /**
     * Searches on theTVDb with a given query for an given identifier.
     *
     * @param string $searchQuery        The query to search for.
     * @param array  $optionalParameters An optional array of search parameters
     *
     * @return array A list of matching SeriesExtendedRecord.
     * @throws ExceptionInterface
     * @throws ParseException
     * @throws ResourceNotFoundException
     * @throws UnauthorizedException
     */
    public function search(string $searchQuery, array $optionalParameters = []): array
    {
        $options = ['query' => []];
        foreach ($optionalParameters as $key => $value) {
            if (static::isValidOptionalParameter($key) === false) {
                throw new InvalidArgumentException($key." is not a valid search argument!");
            }
            $options['query'][$key] = $value;
        }
        $options['query']["query"] = $searchQuery;

        $json = $this->parent->performAPICallWithJsonResponse('get', 'search', $options);
        return DataParser::parseDataArray($json, SearchResult::class);
    }


}
