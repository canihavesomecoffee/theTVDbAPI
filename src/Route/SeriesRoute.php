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
 * Route that exposes the series methods of TheTVDb API.
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
use CanIHaveSomeCoffee\TheTVDbAPI\Exception\ParseException;
use CanIHaveSomeCoffee\TheTVDbAPI\Model\Actor;
use CanIHaveSomeCoffee\TheTVDbAPI\Model\BasicEpisode;
use CanIHaveSomeCoffee\TheTVDbAPI\Model\Image;
use CanIHaveSomeCoffee\TheTVDbAPI\Model\ImageQueryParams;
use CanIHaveSomeCoffee\TheTVDbAPI\Model\ImageStatistics;
use CanIHaveSomeCoffee\TheTVDbAPI\Model\PaginatedResults;
use CanIHaveSomeCoffee\TheTVDbAPI\Model\Series;
use CanIHaveSomeCoffee\TheTVDbAPI\Model\SeriesStatistics;
use DateTimeImmutable;

/**
 * Class SeriesRoute
 *
 * @category TheTVDbAPI
 * @package  CanIHaveSomeCoffee\TheTVDbAPI\Route
 * @author   Willem Van Iseghem (canihavesomecoffee) <theTVDbAPI@canihavesome.coffee>
 * @license  See start of document
 * @link     https://canihavesome.coffee/projects/theTVDbAPI
 */
class SeriesRoute extends AbstractRoute
{
    /**
     * The format used to parse Last-Modified headers.
     */
    const LAST_MODIFIED_FORMAT = 'D, d M Y H:i:s e';


    /**
     * Returns a series record that contains all information known about a particular series ID.
     *
     * @param int $id The id of the series.
     *
     * @return Series
     */
    public function getById(int $id): Series
    {
        $json = $this->parent->performAPICallWithJsonResponse('getUserData', '/series/'.$id);
        return DataParser::parseData($json, Series::class);
    }

    /**
     * Fetches the last modified parameter for a series through a HEAD request.
     *
     * @param int $id The id of the series.
     *
     * @return DateTimeImmutable The datetime for when the series was last modified.
     * @throws ParseException is thrown when the header is missing or couldn't be parsed.
     */
    public function getLastModified(int $id): DateTimeImmutable
    {
        $headers = $this->parent->requestHeaders('head', '/series/'.$id);

        if (array_key_exists('Last-Modified', $headers) && array_key_exists(0, $headers['Last-Modified'])) {
            $last_modified = DateTimeImmutable::createFromFormat(
                static::LAST_MODIFIED_FORMAT,
                $headers['Last-Modified'][0]
            );

            if ($last_modified === false) {
                throw ParseException::lastModified($headers['Last-Modified'][0]);
            }

            return $last_modified;
        }

        throw ParseException::missingHeader('Last-Modified');
    }

    /**
     * Returns actors for the given series ID.
     *
     * @param int $id The id of the series.
     *
     * @return array An array of series actors.
     */
    public function getActors(int $id): array
    {
        $json = $this->parent->performAPICallWithJsonResponse('getUserData', '/series/'.$id.'/actors');
        return DataParser::parseDataArray($json, Actor::class);
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
        $options = ['query' => ['page' => $page]];

        $json = $this->parent->performAPICallWithJsonResponse('getUserData', '/series/'.$id.'/episodes', $options);

        return new PaginatedResults(
            DataParser::parseDataArray($json, BasicEpisode::class),
            $this->parent->getLastLinks()
        );
    }

    /**
     * Retrieves the possible parameters that can be used to search for episodes.
     *
     * @param int $id The id of the series.
     *
     * @return array An array of query keys as strings.
     */
    public function getEpisodesQueryParams(int $id): array
    {
        return $this->parent->performAPICallWithJsonResponse('getUserData', '/series/'.$id.'/episodes/query/params');
    }

    /**
     * Fetches episodes filtered on the given query.
     *
     * @param int   $id    The series id.
     * @param array $query The query parameters to filter episodes on.
     *
     * @return PaginatedResults The paginated episodes that match the query.
     */
    public function getEpisodesWithQuery(int $id, array $query): PaginatedResults
    {
        $json = $this->parent->performAPICallWithJsonResponse(
            'getUserData',
            '/series/'.$id.'/episodes/query',
            ['query' => $query]
        );

        return new PaginatedResults(
            DataParser::parseDataArray($json, BasicEpisode::class),
            $this->parent->getLastLinks()
        );
    }

    /**
     * Returns statistics about how many seasons & episodes were aired.
     *
     * @param int $id The series id.
     *
     * @return SeriesStatistics Statistics on the given series.
     */
    public function getEpisodesSummary(int $id): SeriesStatistics
    {
        $json = $this->parent->performAPICallWithJsonResponse('getUserData', '/series/'.$id.'/episodes/summary');

        return DataParser::parseData($json, SeriesStatistics::class);
    }

    /**
     * Gets the available filters for the 'getWithFilter' method.
     *
     * @param int $id The series id.
     *
     * @return array A list of available filters.
     */
    public function getFilterParams(int $id): array
    {
        return $this->parent->performAPICallWithJsonResponse('getUserData', '/series/'.$id.'/filter/params');
    }

    /**
     * Fetches the data for a series, but only with the attributes that are provided.
     *
     * @param int   $id   The series id.
     * @param array $keys The keys that should be returned.
     *
     * @return array A key -> value list with the retrieved data.
     */
    public function getWithFilter(int $id, array $keys): array
    {
        return $this->parent->performAPICallWithJsonResponse(
            'getUserData',
            '/series/'.$id.'/filter',
            [
                'query' => ['keys' => join(',', $keys)]
            ]
        );
    }

    /**
     * Fetches statistics on the submitted images.
     *
     * @param int $id The id of the series.
     *
     * @return ImageStatistics An instance with series statistics.
     */
    public function getImages(int $id): ImageStatistics
    {
        $json = $this->parent->performAPICallWithJsonResponse('getUserData', '/series/'.$id.'/images');

        return DataParser::parseData($json, ImageStatistics::class);
    }

    /**
     * Returns the allowed query keys for the /images/query route. Contains a parameter record for each unique
     * keyType, listing values that will return results.
     *
     * @param int $id The series id.
     *
     * @return array A list of all available query params
     */
    public function getImagesQueryParams(int $id): array
    {
        $json = $this->parent->performAPICallWithJsonResponse('getUserData', '/series/'.$id.'/images/query/params');

        return DataParser::parseDataArray($json, ImageQueryParams::class);
    }

    /**
     * Query images for the given series ID.
     *
     * E.g.: $query = [
     *      'keyType' => 'fanart',
     *      'resolution' => '1920x1080',
     *      'subKey' => 'graphical'
     * ]
     *
     * @param int   $id    The series id.
     * @param array $query The query parameters.
     *
     * @return array A list of found images
     */
    public function getImagesWithQuery(int $id, array $query): array
    {
        $json = $this->parent->performAPICallWithJsonResponse(
            'getUserData',
            '/series/'.$id.'/images/query',
            ['query' => $query]
        );

        return DataParser::parseDataArray($json, Image::class);
    }
}
