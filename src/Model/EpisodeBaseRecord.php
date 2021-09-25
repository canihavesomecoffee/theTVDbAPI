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
 * Provides a class with the minimal data an episode contains.
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

use DateTime;

/**
 * Class EpisodeBaseRecord
 *
 * @category TheTVDbAPI
 * @package  CanIHaveSomeCoffee\TheTVDbAPI\Model
 * @author   Willem Van Iseghem (canihavesomecoffee) <theTVDbAPI@canihavesome.coffee>
 * @license  See start of document
 * @link     https://canihavesome.coffee/projects/theTVDbAPI
 */
class EpisodeBaseRecord
{
    /**
     * Y-m-d string value of first time the episode aired.
     *
     * @var string|null
     */
    public ?string $aired;
    /**
     * TVDb episode id.
     *
     * @var integer
     */
    public int $id;
    /**
     * Link to image.
     *
     * @var string|null URL to the image related to this base record of an episode.
     */
    public ?string $image;
    /**
     * Image type for the image of this EpisodeBaseRecord
     *
     * @var float|integer|null
     */
    public $imageType;
    /**
     * Movie ID if this is related to a movie.
     *
     * @var integer
     */
    public int $isMovie;
    /**
     * EpisodeExtendedRecord name.
     *
     * @var string|null
     */
    public ?string $name;
    /**
     * List of languages for which translated episode names are available.
     *
     * @var string[]|null
     */
    public ?array $nameTranslations;
    /**
     * List of languages for which translated episode overviews are available.
     *
     * @var string[]|null
     */
    public ?array $overviewTranslations;
    /**
     * Runtime of this episode in minutes
     *
     * @var float|integer|null
     */
    public $runtime;
    /**
     * A list of seasons this episode features in.
     *
     * @var SeasonBaseRecord[]|null Entries are of SeasonBaseRecord classes.
     */
    public ?array $seasons;
    /**
     * SeriesExtendedRecord id for this episode.
     *
     * @var integer
     */
    public int $seriesId;
    /**
     * Season number.
     *
     * @var integer
     */
    public int $seasonNumber;
    /**
     * Season episode nr.
     *
     * @var integer
     */
    public int $number;
    /**
     * The last time this episode got an update.
     *
     * @var DateTime|null
     */
    public ?DateTime $lastUpdated;
    /**
     * The overview if provided.
     *
     * @var string|null
     */
    public ?string $overview;
}
