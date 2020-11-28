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
 * Route that exposes the episodes methods of TheTVDb API.
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
use CanIHaveSomeCoffee\TheTVDbAPI\Model\EpisodeExtendedRecord;
use CanIHaveSomeCoffee\TheTVDbAPI\Model\Translation;
use Exception;
use Symfony\Component\Serializer\Exception\ExceptionInterface;

/**
 * Class EpisodesRoute
 *
 * @category TheTVDbAPI
 * @package  CanIHaveSomeCoffee\TheTVDbAPI\Route
 * @author   Willem Van Iseghem (canihavesomecoffee) <theTVDbAPI@canihavesome.coffee>
 * @license  See start of document
 * @link     https://canihavesome.coffee/projects/theTVDbAPI
 */
class EpisodesRoute extends AbstractRoute
{


    /**
     * Returns the simple information for a given episode ID.
     *
     * @param int $episodeId The episode ID.
     *
     * @return EpisodeBaseRecord The simple episode, if found.
     * @throws ParseException
     * @throws UnauthorizedException
     * @throws ResourceNotFoundException
     * @throws Exception|ExceptionInterface
     */
    public function simple(int $episodeId): EpisodeBaseRecord
    {
        $json = $this->parent->performAPICallWithJsonResponse('get', 'episodes/'.$episodeId);
        return DataParser::parseData($json, EpisodeBaseRecord::class);
    }

    /**
     * Returns the extended information for a given episode ID.
     *
     * @param int $episodeId The episode ID.
     *
     * @return EpisodeExtendedRecord The extended episode, if found.
     * @throws ParseException
     * @throws UnauthorizedException
     * @throws ResourceNotFoundException
     * @throws Exception|ExceptionInterface
     */
    public function extended(int $episodeId): EpisodeExtendedRecord
    {
        $json = $this->parent->performAPICallWithJsonResponse('get', 'episodes/'.$episodeId.'/extended');
        return DataParser::parseData($json, EpisodeExtendedRecord::class);
    }

    /**
     * Returns the simple information for a given episode ID.
     *
     * @param int    $episodeId The episode ID.
     * @param string $lng       The language name.
     *
     * @return Translation The translation for the episode, if found.
     * @throws ParseException
     * @throws UnauthorizedException
     * @throws ResourceNotFoundException
     * @throws Exception|ExceptionInterface
     */
    public function translations(int $episodeId, string $lng): Translation
    {
        $json = $this->parent->performAPICallWithJsonResponse('get', 'episodes/'.$episodeId.'/translations/'.$lng);
        return DataParser::parseData($json, Translation::class);
    }


}
