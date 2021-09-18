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
 * Route that exposes the update methods of TheTVDb API.
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
use CanIHaveSomeCoffee\TheTVDbAPI\Model\EntityUpdate;
use CanIHaveSomeCoffee\TheTVDbAPI\Model\Update;
use DateTime;
use Symfony\Component\Serializer\Exception\ExceptionInterface;

/**
 * Class UpdatesRoute
 *
 * @category TheTVDbAPI
 * @package  CanIHaveSomeCoffee\TheTVDbAPI\Route
 * @author   Willem Van Iseghem (canihavesomecoffee) <theTVDbAPI@canihavesome.coffee>
 * @license  See start of document
 * @link     https://canihavesome.coffee/projects/theTVDbAPI
 */
class UpdatesRoute extends AbstractRoute
{
    public static array $types = [
        "artwork", "award_nominees", "companies", "episodes", "lists", "people", "seasons", "series", "seriespeople",
        "artworktypes", "award_categories", "awards", "company_types", "content_ratings", "countries", "entity_types",
        "genres", "languages", "movies", "movie_genres", "movie_status", "peopletypes", "seasontypes", "sourcetypes",
        "tag_options", "tags", "translatedcharacters", "translatedcompanies", "translatedepisodes", "translatedlists",
        "translatedmovies", "translatedpeople", "translatedseasons", "translatedseries"];


    /**
     * Fetches data that was updated between the given timestamps.
     *
     * @param DateTime $since  Fetch data that was updated after this timestamp.
     * @param string   $type   The type of data to fetch.
     * @param string   $action The action (delete or update).
     * @param int      $page   The page to fetch.
     *
     * @return array An array with Update instances.
     * @throws ExceptionInterface
     * @throws ParseException
     * @throws ResourceNotFoundException
     * @throws UnauthorizedException
     */
    public function query(DateTime $since, string $type = "", string $action = "", int $page = -1): array
    {
        $query = ['since' => $since->getTimestamp()];
        if ($type !== "") {
            if (in_array($type, static::$types) === false) {
                throw new \InvalidArgumentException("Type is not in the allowed list of types");
            }
            $query['type'] = $type;
        }
        if ($action === "delete" || $action === "update") {
            $query['action'] = $action;
        }
        if ($page >= 0) {
            $query['page'] = $page;
        }
        $options = ['query' => $query];

        $json = $this->parent->performAPICallWithJsonResponse('get', 'updates', $options);
        return DataParser::parseDataArray($json, EntityUpdate::class);
    }

    /**
     * Fetches updates for series.
     *
     * @param DateTime $since  Fetch data that was updated after this timestamp.
     * @param string   $action The action (delete or update).
     * @param int      $page   The page to fetch.
     *
     * @return array An array with Update instances.
     * @throws ExceptionInterface
     * @throws ParseException
     * @throws ResourceNotFoundException
     * @throws UnauthorizedException
     */
    public function fetchSerieUpdates(DateTime $since, string $action = "", int $page = -1): array
    {
        return $this->query($since, "series", $action, $page);
    }


    /**
     * Fetches updates for episodes.
     *
     * @param DateTime $since  Fetch data that was updated after this timestamp.
     * @param string   $action The action (delete or update).
     * @param int      $page   The page to fetch.
     *
     * @return array An array with Update instances.
     * @throws ExceptionInterface
     * @throws ParseException
     * @throws ResourceNotFoundException
     * @throws UnauthorizedException
     */
    public function fetchEpisodeUpdates(DateTime $since, string $action = "", int $page = -1): array
    {
        return $this->query($since, "episodes", $action, $page);
    }


}
