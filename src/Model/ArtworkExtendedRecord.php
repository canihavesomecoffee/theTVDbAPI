<?php
/**
 * Copyright (c) 2020, Willem Van Iseghem (canihavesomecoffee) <theTVDbAPI@canihavesome.coffee>
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
 * Provides a class with the data an extended record of artwork contains.
 *
 * PHP version 7.4
 *
 * @category TheTVDbAPI
 * @package  CanIHaveSomeCoffee\TheTVDbAPI\Model
 * @author   Willem Van Iseghem (canihavesomecoffee) <theTVDbAPI@canihavesome.coffee>
 * @license  See start of document
 * @link     https://canihavesome.coffee/projects/theTVDbAPI
 */
declare(strict_types = 1);

namespace CanIHaveSomeCoffee\TheTVDbAPI\Model;

/**
 * Class ArtworkExtendedRecord
 *
 * @category TheTVDbAPI
 * @package  CanIHaveSomeCoffee\TheTVDbAPI\Model
 * @author   Willem Van Iseghem (canihavesomecoffee) <theTVDbAPI@canihavesome.coffee>
 * @license  See start of document
 * @link     https://canihavesome.coffee/projects/theTVDbAPI
 */
class ArtworkExtendedRecord extends ArtworkBaseRecord
{
    /**
     * The ID of the episode which this artwork belongs to.
     *
     * @var float|integer|null
     */
    public $episodeId;
    /**
     * The height of this artwork.
     *
     * @var integer
     */
    public int $height;
    /**
     * The ID of the movie which this artwork belongs to.
     *
     * @var float|integer|null
     */
    public $movieId;
    /**
     * The ID of the network which this artwork belongs to.
     *
     * @var float|integer|null
     */
    public $networkId;
    /**
     * The ID of the person which this artwork belongs to.
     *
     * @var float|integer|null
     */
    public $peopleId;
    /**
     * The ID of the season which this artwork belongs to.
     *
     * @var float|integer|null
     */
    public $seasonId;
    /**
     * The ID of the series which this artwork belongs to.
     *
     * @var float|integer|null
     */
    public $seriesId;
    /**
     * The ID of the persons in the series which this artwork belongs to.
     *
     * @var float|integer|null
     */
    public $seriesPeopleId;
    /**
     * The height of the thumbnail for this artwork.
     *
     * @var integer
     */
    public int $thumbnailHeight;
    /**
     * The width of the thumbnail for this artwork.
     *
     * @var integer
     */
    public int $thumbnailWidth;
    /**
     * Unix timestamp of last update to the artwork.
     *
     * @var integer
     */
    public int $updatedAt;
    /**
     * The width of this artwork.
     *
     * @var integer
     */
    public int $width;
}
