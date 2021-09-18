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
use CanIHaveSomeCoffee\TheTVDbAPI\Model\EpisodeBaseRecord;
use CanIHaveSomeCoffee\TheTVDbAPI\Model\SeriesBaseRecord;
use CanIHaveSomeCoffee\TheTVDbAPI\Model\SeriesExtendedRecord;
use CanIHaveSomeCoffee\TheTVDbAPI\Model\Translation;
use DateTimeImmutable;
use Symfony\Component\Serializer\Exception\ExceptionInterface;

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
     * Default season order.
     */
    const SEASON_TYPE_DEFAULT = "default";
    /**
     * Official season order.
     */
    const SEASON_TYPE_OFFICIAL = "official";
    /**
     * DVD season order.
     */
    const SEASON_TYPE_DVD = "dvd";
    /**
     * Absolute season order.
     */
    const SEASON_TYPE_ABSOLUTE = "absolute";
    /**
     * Alternate season order.
     */
    const SEASON_TYPE_ALTERNATE = "alternate";
    /**
     * Regional season order.
     */
    const SEASON_TYPE_REGIONAL = "regional";


    /**
     * Check if the given type is a valid season type.
     *
     * @param string $type The type to check.
     *
     * @return bool
     */
    public static function isValidSeasonType(string $type) : bool
    {
        return in_array(
            $type,
            [
                static::SEASON_TYPE_ABSOLUTE,
                static::SEASON_TYPE_ALTERNATE,
                static::SEASON_TYPE_DEFAULT,
                static::SEASON_TYPE_DVD,
                static::SEASON_TYPE_OFFICIAL,
                static::SEASON_TYPE_REGIONAL,
            ]
        );
    }


    /**
     * Get a list of episodes.
     *
     * @param int $page The page number (optional).
     *
     * @return array
     * @throws ExceptionInterface
     * @throws ParseException
     * @throws ResourceNotFoundException
     * @throws UnauthorizedException
     */
    public function list(int $page = 0): array
    {
        $options = ['query' => ['page' => $page]];
        $json    = $this->parent->performAPICallWithJsonResponse('get', 'series', $options);
        return DataParser::parseDataArray($json, SeriesBaseRecord::class);
    }

    /**
     * Returns a series record that contains all information known about a particular series ID.
     *
     * @param int $id The id of the series.
     *
     * @return SeriesBaseRecord
     * @throws ParseException
     * @throws ResourceNotFoundException
     * @throws UnauthorizedException
     * @throws ExceptionInterface
     */
    public function simple(int $id): SeriesBaseRecord
    {
        $json = $this->parent->performAPICallWithJsonResponse('get', 'series/'.$id);
        return DataParser::parseData($json, SeriesBaseRecord::class);
    }

    /**
     * Returns a series record that contains all information known about a particular series ID.
     *
     * @param int $id The id of the series.
     *
     * @return SeriesExtendedRecord
     * @throws ParseException
     * @throws ResourceNotFoundException
     * @throws UnauthorizedException
     * @throws ExceptionInterface
     */
    public function extended(int $id): SeriesExtendedRecord
    {
        $json = $this->parent->performAPICallWithJsonResponse('get', 'series/'.$id.'/extended');
        return DataParser::parseData($json, SeriesExtendedRecord::class);
    }

    /**
     * Returns paginated episodes of the series with 100 results per page.
     *
     * @param int    $id         The id of the series to retrieve.
     * @param int    $season     The season to retrieve.
     * @param int    $page       The page to start with (defaults to 1).
     * @param string $seasonType The season type. Defaults to default.
     * @param string $lang       The language for translated episodes.
     *
     * @return array An array of base episode records. Empty if not enough episodes available.
     * @throws ParseException
     * @throws ResourceNotFoundException
     * @throws UnauthorizedException
     * @throws ExceptionInterface
     */
    public function episodes(int $id, int $season = 0, int $page = 0, string $seasonType = self::SEASON_TYPE_DEFAULT, string $lang = ""): array
    {
        if (static::isValidSeasonType($seasonType) === false) {
            throw new \InvalidArgumentException("Given season type is not valid");
        }
        $options = ['query' => ['page' => $page, 'season' => $season]];

        $path = 'series/'.$id.'/episodes/'.$seasonType;
        if ($lang !== "") {
            $path .= "/".$lang;
        }
        $json = $this->parent->performAPICallWithJsonResponse('get', $path, $options);

        return DataParser::parseDataArray($json['episodes'], EpisodeBaseRecord::class);
    }

    /**
     * Consecutively calls getEpisodes to run through all the paginated results
     * and groups them together in a single array.
     *
     * @param int    $id         The id of the series to retrieve.
     * @param int    $season     The season to retrieve.
     * @param string $seasonType The season type. Defaults to default.
     * @param string $lang       The language for translated episodes.
     *
     * @return array An array of EpisodeBaseRecord instances.
     * @throws ParseException
     * @throws ResourceNotFoundException
     * @throws UnauthorizedException
     * @throws ExceptionInterface
     */
    public function allEpisodes(int $id, int $season = 0, string $seasonType = self::SEASON_TYPE_DEFAULT, string $lang = ""): array
    {
        $currentPage = 1;
        $allEpisodes = [];
        do {
            $results     = $this->episodes($id, $season, $currentPage, $seasonType, $lang);
            $allEpisodes = array_merge($allEpisodes, $results);
            $currentPage++;
            if (sizeof($results) < 100) {
                break;
            }
        } while ($currentPage > 0);
        return $allEpisodes;
    }

    /**
     * Retrieves the possible parameters that can be used to search for episodes.
     *
     * @param int    $id   The id of the series.
     * @param string $lang The language string to retrieve
     *
     * @return Translation The translated series info.
     * @throws ParseException
     * @throws ResourceNotFoundException
     * @throws UnauthorizedException
     * @throws ExceptionInterface
     */
    public function translate(int $id, string $lang): Translation
    {
        $json = $this->parent->performAPICallWithJsonResponse('get', 'series/'.$id.'/translations/'.$lang);
        return DataParser::parseData($json, Translation::class);
    }


}
