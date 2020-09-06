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
 * Route that exposes the search methods of TheTVDb API. It extends the original route in order to perform look-ups
 * with fallback languages if the primary language does not fill in all fields.
 *
 * PHP version 7.1
 *
 * @category TheTVDbAPI
 * @package  CanIHaveSomeCoffee\TheTVDbAPI\MultiLanguageWrapper\Route
 * @author   Willem Van Iseghem (canihavesomecoffee) <theTVDbAPI@canihavesome.coffee>
 * @license  See start of document
 * @link     https://canihavesome.coffee/projects/theTVDbAPI
 */
declare(strict_types = 1);

namespace CanIHaveSomeCoffee\TheTVDbAPI\MultiLanguageWrapper\Route;

use CanIHaveSomeCoffee\TheTVDbAPI\DataParser;
use CanIHaveSomeCoffee\TheTVDbAPI\Model\BasicSeries;
use CanIHaveSomeCoffee\TheTVDbAPI\MultiLanguageWrapper\TheTVDbAPILanguageFallback;
use CanIHaveSomeCoffee\TheTVDbAPI\Route\SearchRoute;
use Closure;
use InvalidArgumentException;

/**
 * Class SearchRouteLanguageFallback
 *
 * @category TheTVDbAPI
 * @package  CanIHaveSomeCoffee\TheTVDbAPI\Route
 * @author   Willem Van Iseghem (canihavesomecoffee) <theTVDbAPI@canihavesome.coffee>
 * @license  See start of document
 * @link     https://canihavesome.coffee/projects/theTVDbAPI
 */
class SearchRouteLanguageFallback extends SearchRoute
{


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
        /* @var TheTVDbAPILanguageFallback $parent */
        $parent  = $this->parent;
        $closure = $this->getClosureForSearch($options);
        return $parent->getGenerator()->create(
            $closure,
            BasicSeries::class,
            $this->parent->getAcceptedLanguages(),
            true,
            []
        );
    }

    /**
     * Returns the closure used to execute a search for a single language.
     *
     * @param array $options The options for the search.
     *
     * @return Closure
     */
    public function getClosureForSearch(array $options): Closure
    {
        return function ($language) use ($options) {
            $json = $this->parent->performAPICallWithJsonResponse(
                'get',
                '/search/series',
                array_merge($options, ['headers' => ['Accept-Language' => $language]])
            );
            return DataParser::parseDataArray($json, BasicSeries::class);
        };
    }
}
