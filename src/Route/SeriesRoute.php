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
use CanIHaveSomeCoffee\TheTVDbAPI\Model\ArtworkBaseRecord;
use CanIHaveSomeCoffee\TheTVDbAPI\Model\EpisodeBaseRecord;
use CanIHaveSomeCoffee\TheTVDbAPI\Model\SeriesBaseRecord;
use CanIHaveSomeCoffee\TheTVDbAPI\Model\SeriesExtendedRecord;
use CanIHaveSomeCoffee\TheTVDbAPI\Model\Translation;
use DateTime;
use InvalidArgumentException;
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
     * Returns paginated episodes of the series with 100 results per page. If you pass a language, it will fetch
     * all episodes instead.
     *
     * @param int           $id            The id of the series to retrieve.
     * @param int           $season        The season to retrieve.
     * @param int           $page          The page to start with (defaults to 1).
     * @param string        $seasonType    The season type. Defaults to default.
     * @param string        $lang          The language for translated episodes.
     * @param int           $episodeNumber The episode number of an episode (optional).
     * @param DateTime|null $airDate       The airdate of an episode (optional).
     *
     * @return EpisodeBaseRecord[] An array of base episode records. Empty if not enough episodes available.
     * @throws ParseException
     * @throws ResourceNotFoundException
     * @throws UnauthorizedException
     * @throws ExceptionInterface
     */
    public function episodes(
        int $id,
        int $season = 0,
        int $page = 0,
        string $seasonType = self::SEASON_TYPE_DEFAULT,
        string $lang = "",
        int $episodeNumber = -1,
        ?DateTime $airDate = null
    ): array {
        if (static::isValidSeasonType($seasonType) === false) {
            throw new InvalidArgumentException("Given season type is not valid");
        }
        $arguments = ['page' => $page];

        $path = 'series/'.$id.'/episodes/'.$seasonType;
        if ($lang !== "") {
            $path .= "/".$lang;
        } else {
            $arguments['season'] = $season;
        }
        if ($episodeNumber > -1) {
            $arguments['episodeNumber'] = $episodeNumber;
        }
        if ($airDate !== null) {
            $arguments['airDate'] = $airDate->format("Y-m-d");
        }
        $options = ['query' => $arguments];
        $json    = $this->parent->performAPICallWithJsonResponse('get', $path, $options);

        $episodes = [];
        if (isset($json['episodes'])) {
            $episodes = $json['episodes'];
        }
        return DataParser::parseDataArray($episodes, EpisodeBaseRecord::class);
    }

    /**
     * Fetch all available episode for this series and season type, localized to primary language. Will merge in
     * episodes in the fallback language if this is specified.
     *
     * @param int    $id         The id of the series to retrieve.
     * @param string $seasonType The season type. Defaults to default.
     *
     * @return EpisodeBaseRecord[] An array of base episode records. Empty if not enough episodes available.
     * @throws ParseException
     * @throws ResourceNotFoundException
     * @throws UnauthorizedException
     * @throws ExceptionInterface
     */
    public function allEpisodes(int $id, string $seasonType = self::SEASON_TYPE_DEFAULT) : array
    {
        $result = [];

        // Boolean to catch throw.
        $throwS = false;
        $throwP = false;

        if ($this->parent->getSecondaryLanguage() !== "") {
            // Pre-fill results with fallback language, assuming the fallback language always has more results than the
            // translated, primary language.
            try {
                $page = 0;
                do {
                    $eps = $this->episodes($id, 0, $page, $seasonType, $this->parent->getSecondaryLanguage());
                    foreach ($eps as $episode) {
                        $result[$episode->id] = $episode;
                    }
                    $page++;
                } while (sizeof($eps) === 500);
            } catch (ResourceNotFoundException $exception) {
                $throwS = true;
            }
        }
        try {
            $page = 0;
            do {
                $translatedEpisodes = $this->episodes($id, 0, $page, $seasonType, $this->parent->getPrimaryLanguage());
                foreach ($translatedEpisodes as $episode) {
                    if (array_key_exists($episode->id, $result)) {
                        $result[$episode->id]->name     = ($episode->name ?? $result[$episode->id]->name);
                        $result[$episode->id]->overview = ($episode->overview ?? $result[$episode->id]->overview);
                    } else {
                        $result[$episode->id] = $episode;
                    }
                }
                $page++;
            } while (sizeof($translatedEpisodes) === 500);
        } catch (ResourceNotFoundException $exception) {
            $throwP = true;
        }

        if ($throwS && $throwP) {
            throw ResourceNotFoundException::noTranslationAvailable();
        }

        return array_values($result);
    }

    /**
     * Fetch all available episode for this series and season type, localized to the original language.
     *
     * @param SeriesBaseRecord $series     The series to retrieve episodes for.
     * @param string           $seasonType The season type. Defaults to default.
     *
     * @return EpisodeBaseRecord[] An array of base episode records.
     * @throws ExceptionInterface
     * @throws ParseException
     * @throws ResourceNotFoundException
     * @throws UnauthorizedException
     */
    public function allEpisodesOriginalLanguage(
        SeriesBaseRecord $series,
        string $seasonType = self::SEASON_TYPE_DEFAULT
    ) : array {
        $result = [];

        $page = 0;
        do {
            $eps = $this->episodes($series->id, 0, $page, $seasonType, $series->originalLanguage);
            foreach ($eps as $episode) {
                $result[$episode->id] = $episode;
            }
            $page++;
        } while (sizeof($eps) === 500);

        return array_values($result);
    }

    /**
     * Retrieves the possible parameters that can be used to search for episodes.
     *
     * @param int $id The id of the series.
     *
     * @return Translation The translated series info.
     * @throws ParseException
     * @throws ResourceNotFoundException
     * @throws UnauthorizedException
     * @throws ExceptionInterface
     */
    public function translate(int $id): Translation
    {
        try {
            $json = $this->parent->performAPICallWithJsonResponse(
                'get',
                'series/'.$id.'/translations/'.$this->parent->getPrimaryLanguage()
            );
        } catch (ResourceNotFoundException $exc) {
            $json = $this->parent->performAPICallWithJsonResponse(
                'get',
                'series/'.$id.'/translations/'.$this->parent->getSecondaryLanguage()
            );
        }
        return DataParser::parseData($json, Translation::class);
    }

    /**
     * Retrieves artwork for a series
     *
     * @param int    $id   The id of the series.
     * @param string $lang The languages to look for artwork. (comma separated)
     * @param int    $type The type of artwork.
     *
     * @return ArtworkBaseRecord[]
     * @throws ParseException
     * @throws ResourceNotFoundException
     * @throws UnauthorizedException
     * @throws ExceptionInterface
     */
    public function artworks(int $id, string $lang = "", int $type = -1): array
    {
        $arguments = [];
        if ($lang !== "") {
            $arguments['lang'] = $lang;
        }
        if ($type > -1) {
            $arguments['type'] = $type;
        }
        $options  = ['query' => $arguments];
        $json     = $this->parent->performAPICallWithJsonResponse('get', 'series/'.$id.'/artworks', $options);
        $artworks = [];
        if (isset($json['artworks'])) {
            $artworks = $json['artworks'];
        }
        return DataParser::parseDataArray($artworks, ArtworkBaseRecord::class);
    }


}
