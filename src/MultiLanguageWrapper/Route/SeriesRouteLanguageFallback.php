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
 * Route that exposes the series methods of TheTVDb API. It extends the original route in order to perform look-ups
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
use CanIHaveSomeCoffee\TheTVDbAPI\Model\BasicEpisode;
use CanIHaveSomeCoffee\TheTVDbAPI\Model\PaginatedResults;
use CanIHaveSomeCoffee\TheTVDbAPI\Model\Series;
use CanIHaveSomeCoffee\TheTVDbAPI\MultiLanguageWrapper\TheTVDbAPILanguageFallback;
use CanIHaveSomeCoffee\TheTVDbAPI\Route\SeriesRoute;

/**
 * Class SeriesRouteLanguageFallback
 *
 * @category TheTVDbAPI
 * @package  CanIHaveSomeCoffee\TheTVDbAPI\Route
 * @author   Willem Van Iseghem (canihavesomecoffee) <theTVDbAPI@canihavesome.coffee>
 * @license  See start of document
 * @link     https://canihavesome.coffee/projects/theTVDbAPI
 */
class SeriesRouteLanguageFallback extends SeriesRoute
{


    /**
     * Returns a series record that contains all information known about a particular series ID.
     *
     * @param int $id The id of the series.
     *
     * @return Series
     */
    public function getById(int $id): Series
    {
        /** @var TheTVDbAPILanguageFallback $parent */
        $parent = $this->parent;
        $series_id = $id;
        $closure = function ($language) use ($series_id) {
            $json = $this->parent->performAPICallWithJsonResponse(
                'get',
                '/series/' . $series_id,
                [
                    'headers' => ['Accept-Language' => $language]
                ]
            );

            return DataParser::parseData($json, Series::class);
        };

        return $parent->getGenerator()->create($closure, Series::class, $this->parent->getAcceptedLanguages());
    }

    /**
     * All episodes for a given series. Paginated with 100 results per page.
     *
     * @param int $id   The id of the series to retrieve.
     * @param int $page The page to start with (defaults to 1).
     *
     * @return PaginatedResults An instance of PaginatedResults.
     */
    public function getEpisodes(int $id, int $page = 1): PaginatedResults
    {
        /** @var TheTVDbAPILanguageFallback $parent */
        $parent = $this->parent;
        $series_id = $id;
        $options = ['query' => ['page' => $page]];
        $closure = function ($language) use ($series_id, $options) {
            $options['headers'] = ['Accept-Language' => $language];
            $json = $this->parent->performAPICallWithJsonResponse(
                'get',
                '/series/' . $series_id . '/episodes',
                $options
            );

            return DataParser::parseDataArray($json, BasicEpisode::class);
        };

        return new PaginatedResults(
            $parent->getGenerator()->create($closure, BasicEpisode::class, $this->parent->getAcceptedLanguages()),
            $this->parent->getLastLinks()
        );
    }

    /**
     * Fetches episodes filtered on the given query.
     *
     * @param int $id The series id.
     * @param array $query The query parameters to filter episodes on.
     *
     * @return PaginatedResults The paginated episodes that match the query.
     */
    public function getEpisodesWithQuery(int $id, array $query): PaginatedResults
    {
        /** @var TheTVDbAPILanguageFallback $parent */
        $parent = $this->parent;
        $series_id = $id;
        $options = ['query' => $query];
        $closure = function ($language) use ($series_id, $options) {
            $options['headers'] = ['Accept-Language' => $language];
            $json = $this->parent->performAPICallWithJsonResponse(
                'get',
                '/series/' . $series_id . '/episodes/query',
                $options
            );

            return DataParser::parseDataArray($json, BasicEpisode::class);
        };

        return new PaginatedResults(
            $parent->getGenerator()->create($closure, BasicEpisode::class, $this->parent->getAcceptedLanguages()),
            $this->parent->getLastLinks()
        );
    }
}
