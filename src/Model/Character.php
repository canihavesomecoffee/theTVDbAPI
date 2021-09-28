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
 * Provides a class for a character.
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
 * Class Character
 *
 * @category TheTVDbAPI
 * @package  CanIHaveSomeCoffee\TheTVDbAPI\Model
 * @author   Willem Van Iseghem (canihavesomecoffee) <theTVDbAPI@canihavesome.coffee>
 * @license  See start of document
 * @link     https://canihavesome.coffee/projects/theTVDbAPI
 */
class Character
{
    /**
     * Aliases for this character.
     *
     * @var Alias[]|null
     */
    public ?array $aliases;
    /**
     * EpisodeExtendedRecord id if this character is present in there.
     *
     * @var float|integer|null
     */
    public $episodeId;
    /**
     * Identifier for this character.
     *
     * @var integer
     */
    public int $id;
    /**
     * URL to an image of the character.
     *
     * @var string|null
     */
    public ?string $image;
    /**
     * Is this a featured character?
     *
     * @var boolean
     */
    public bool $isFeatured;
    /**
     * Movie id if this character is present in there.
     *
     * @var float|integer|null
     */
    public $movieId;
    /**
     * Name of the character (original).
     *
     * @var string|null
     */
    public ?string $name;
    /**
     * List of languages for which translated character names are available.
     *
     * @var string[]|null
     */
    public ?array $nameTranslations;
    /**
     * List of languages for which translated character overviews are available.
     *
     * @var string[]|null
     */
    public ?array $overviewTranslations;
    /**
     * Link to the portraying actor.
     *
     * @var float|integer|null
     */
    public $peopleId;
    /**
     * SeriesExtendedRecord id if this character is present in there.
     *
     * @var float|integer|null
     */
    public $seriesId;
    /**
     * Unknown property
     *
     * @var integer
     */
    public int $sort;
    /**
     * Type of the character.
     *
     * @var integer
     */
    public int $type;
    /**
     * The URL of this character.
     *
     * @var string
     */
    public string $url;
    /**
     * The name? of this character.
     *
     * @var string
     */
    public string $personName;


}
