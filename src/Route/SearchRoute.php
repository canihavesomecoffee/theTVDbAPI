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

use CanIHaveSomeCoffee\TheTVDbAPI\DataParser;
use CanIHaveSomeCoffee\TheTVDbAPI\Model\BasicSeries;
use InvalidArgumentException;

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
     * Parameter name for searching by name.
     */
    const SEARCH_NAME = 'name';
    /**
     * Parameter name for searching by IMDb id.
     */
    const SEARCH_IMDB = 'imdbId';
    /**
     * Parameter name for searching by zap2it id.
     */
    const SEARCH_ZAP2IT = 'zap2itId';


    /**
     * Searches on theTVDb with a given query for an given identifier.
     *
     * @param string $identifier  The identifier to search on.
     * @param string $searchQuery The query to search for.
     *
     * @return array A list of matching Series.
     */
    public function search(string $identifier, string $searchQuery): array
    {
        if (in_array($identifier, [static::SEARCH_NAME, static::SEARCH_IMDB, static::SEARCH_ZAP2IT]) === false) {
            throw new InvalidArgumentException('Given search identifier is invalid!');
        }
        $options = ['query' => [$identifier => $searchQuery]];

        $json = $this->parent->performAPICallWithJsonResponse('get', '/search/series', $options);
        return DataParser::parseDataArray($json, BasicSeries::class);
    }

    /**
     * Searches on theTVDb for (a) serie(s) with a given name.
     *
     * @param string $name The name to search for.
     *
     * @return array A list of matching Series.
     */
    public function searchByName(string $name): array
    {
        return $this->search(static::SEARCH_NAME, $name);
    }

    /**
     * Searches on theTVDb for (a) serie(s) with a given IMDb id.
     *
     * @param string $imdbId The IMDb id to search for.
     *
     * @return array A list of matching Series.
     */
    public function searchByIMDbId(string $imdbId): array
    {
        return $this->search(static::SEARCH_IMDB, $imdbId);
    }

    /**
     * Searches on theTVDb for (a) serie(s) with a given zap2it id.
     *
     * @param string $zap2itId The zap2it id to search for.
     *
     * @return array A list of matching Series.
     */
    public function searchByZap2ItId(string $zap2itId): array
    {
        return $this->search(static::SEARCH_ZAP2IT, $zap2itId);
    }
}
