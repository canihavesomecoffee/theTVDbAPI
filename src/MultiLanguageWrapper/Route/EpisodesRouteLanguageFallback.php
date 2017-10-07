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
 * Route that exposes the episodes methods of TheTVDb API. It extends the original route in order to perform look-ups
 * with fallback languages if the primary language does not fill in all fields.
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

namespace CanIHaveSomeCoffee\TheTVDbAPI\MultiLanguageWrapper\Route;

use CanIHaveSomeCoffee\TheTVDbAPI\DataParser;
use CanIHaveSomeCoffee\TheTVDbAPI\Exception\ParseException;
use CanIHaveSomeCoffee\TheTVDbAPI\Exception\ResourceNotFoundException;
use CanIHaveSomeCoffee\TheTVDbAPI\Exception\UnauthorizedException;
use CanIHaveSomeCoffee\TheTVDbAPI\Model\Episode;
use CanIHaveSomeCoffee\TheTVDbAPI\MultiLanguageWrapper\TheTVDbAPILanguageFallback;
use CanIHaveSomeCoffee\TheTVDbAPI\Route\EpisodesRoute;
use Closure;
use Exception;

/**
 * Class EpisodesRouteLanguageFallback
 *
 * @category TheTVDbAPI
 * @package  CanIHaveSomeCoffee\TheTVDbAPI\MultiLanguageWrapper\Route
 * @author   Willem Van Iseghem (canihavesomecoffee) <theTVDbAPI@canihavesome.coffee>
 * @license  See start of document
 * @link     https://canihavesome.coffee/projects/theTVDbAPI
 */
class EpisodesRouteLanguageFallback extends EpisodesRoute
{


    /**
     * Returns the full information for a given episode ID.
     *
     * @param int $episodeId The episode ID.
     *
     * @return Episode The full episode, if found.
     * @throws ParseException
     * @throws UnauthorizedException
     * @throws ResourceNotFoundException
     * @throws Exception
     */
    public function byId(int $episodeId): Episode
    {
        /* @var TheTVDbAPILanguageFallback $parent */
        $parent  = $this->parent;
        $closure = $this->getClosureById($episodeId);
        return $parent->getGenerator()->create($closure, Episode::class, $this->parent->getAcceptedLanguages(), true);
    }

    /**
     * Returns the closure used to fetch an episode by id
     * for a single language.
     *
     * @param int $episodeId The episode to fetch.
     *
     * @return Closure
     */
    public function getClosureById(int $episodeId): Closure
    {
        return function ($language) use ($episodeId) {
            $json = $this->parent->performAPICallWithJsonResponse(
                'get',
                '/episodes/'.$episodeId,
                [
                    'headers' => ['Accept-Language' => $language]
                ]
            );
            return DataParser::parseData($json, Episode::class);
        };
    }
}
