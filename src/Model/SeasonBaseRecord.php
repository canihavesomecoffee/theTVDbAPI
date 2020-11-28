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
 *
 *
 * PHP version 7.4
 *
 * @category TheTVDbAPI
 * @package  CanIHaveSomeCoffee\TheTVDbAPI\Model
 * @author   Willem Van Iseghem (canihavesomecoffee) <theTVDbAPI@canihavesome.coffee>
 * @license  See start of document
 * @link     https://canihavesome.coffee/projects/theTVDbAPI
 */

declare(strict_types=1);

namespace CanIHaveSomeCoffee\TheTVDbAPI\Model;

/**
 * Class SeasonBaseRecord
 *
 * @package CanIHaveSomeCoffee\TheTVDbAPI\Model
 */
class SeasonBaseRecord
{
    /**
     * The abbreviation of the season.
     *
     * @var string
     */
    public string $abbreviation;
    /**
     * The country of the season.
     *
     * @var string
     */
    public string $country;
    /**
     * Identifier for this character.
     *
     * @var integer
     */
    public int $id;
    /**
     * URL to an image of the season.
     *
     * @var string
     */
    public string $image;
    /**
     * The image type for the image of the season.
     *
     * @var integer|float|null
     */
    public $imageType;
    /**
     * Name of the season (original).
     *
     * @var string
     */
    public string $name;
    /**
     * List of languages for which translated season names are available.
     *
     * @var array
     */
    public array $nameTranslations;
    /**
     * Number of the season.
     *
     * @var integer
     */
    public int $number;
    /**
     * List of languages for which translated season overviews are available.
     *
     * @var array
     */
    public array $overviewTranslations;
    /**
     * SeriesExtendedRecord id if this season is present in there.
     *
     * @var float|integer|null
     */
    public $seriesId;
    /**
     * Slug of the season.
     *
     * @var string
     */
    public string $slug;
    /**
     * Type of the season.
     *
     * @var integer
     */
    public int $type;
}
