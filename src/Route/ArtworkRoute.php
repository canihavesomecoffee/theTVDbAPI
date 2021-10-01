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
 * Route that exposes the artwork methods of TheTVDb API.
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
use CanIHaveSomeCoffee\TheTVDbAPI\Model\ArtworkExtendedRecord;
use CanIHaveSomeCoffee\TheTVDbAPI\Model\ArtworkStatus;
use CanIHaveSomeCoffee\TheTVDbAPI\Model\ArtworkType;
use CanIHaveSomeCoffee\TheTVDbAPI\Model\EpisodeBaseRecord;
use CanIHaveSomeCoffee\TheTVDbAPI\Model\EpisodeExtendedRecord;
use CanIHaveSomeCoffee\TheTVDbAPI\Model\Translation;
use Exception;
use Symfony\Component\Serializer\Exception\ExceptionInterface;

/**
 * Class ArtworkRoute
 *
 * @category TheTVDbAPI
 * @package  CanIHaveSomeCoffee\TheTVDbAPI\Route
 * @author   Willem Van Iseghem (canihavesomecoffee) <theTVDbAPI@canihavesome.coffee>
 * @license  See start of document
 * @link     https://canihavesome.coffee/projects/theTVDbAPI
 */
class ArtworkRoute extends AbstractRoute
{


    /**
     * Returns the simple information for a given artwork ID.
     *
     * @param int $artworkId The artwork ID.
     *
     * @return ArtworkBaseRecord The simple artwork, if found.
     * @throws ParseException
     * @throws UnauthorizedException
     * @throws ResourceNotFoundException
     * @throws Exception|ExceptionInterface
     */
    public function simple(int $artworkId): ArtworkBaseRecord
    {
        $json = $this->parent->performAPICallWithJsonResponse('get', 'artwork/'.$artworkId);
        return DataParser::parseData($json, ArtworkBaseRecord::class);
    }

    /**
     * Returns the extended information for a given artwork ID.
     *
     * @param int $artworkId The artwork ID.
     *
     * @return ArtworkExtendedRecord The artwork episode, if found.
     * @throws ParseException
     * @throws UnauthorizedException
     * @throws ResourceNotFoundException
     * @throws Exception|ExceptionInterface
     */
    public function extended(int $artworkId): ArtworkExtendedRecord
    {
        $json = $this->parent->performAPICallWithJsonResponse('get', 'artwork/'.$artworkId.'/extended');
        return DataParser::parseData($json, ArtworkExtendedRecord::class);
    }

    /**
     * Fetch list of artwork status records
     *
     * @return ArtworkStatus[]
     * @throws ParseException
     * @throws UnauthorizedException
     * @throws ResourceNotFoundException
     * @throws Exception|ExceptionInterface
     */
    public function statuses(): array
    {
        $json = $this->parent->performAPICallWithJsonResponse('get', 'artwork/statuses');
        return DataParser::parseDataArray($json, ArtworkStatus::class);
    }

    /**
     * Fetch list of artwork type records
     *
     * @return ArtworkType[]
     * @throws ParseException
     * @throws UnauthorizedException
     * @throws ResourceNotFoundException
     * @throws Exception|ExceptionInterface
     */
    public function types(): array
    {
        $json = $this->parent->performAPICallWithJsonResponse('get', 'artwork/types');
        return DataParser::parseDataArray($json, ArtworkType::class);
    }


}
