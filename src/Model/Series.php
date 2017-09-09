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
 * Provides a class with the data a series contains.
 *
 * PHP version 7.1
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
 * Class Series
 *
 * @category TheTVDbAPI
 * @package  CanIHaveSomeCoffee\TheTVDbAPI\Model
 * @author   Willem Van Iseghem (canihavesomecoffee) <theTVDbAPI@canihavesome.coffee>
 * @license  See start of document
 * @link     https://canihavesome.coffee/projects/theTVDbAPI
 */
class Series extends BasicSeries
{
    /**
     * Y-m-d of when the show was added to theTVDb.
     *
     * @var string
     */
    public $added;
    /**
     * The day of the week when the serie airs.
     *
     * @var string
     */
    public $airsDayOfWeek;
    /**
     * Time when the series airs.
     *
     * @var string
     */
    public $airsTime;
    /**
     * An array containing the genre(s) of the series.
     *
     * @var array
     */
    public $genre;
    /**
     * The IMDb id of this series.
     *
     * @var string
     */
    public $imdbId;
    /**
     * The unix timestamp when the series was last updated.
     *
     * @var int
     */
    public $lastUpdated;
    /**
     * The network id.
     *
     * @var string
     */
    public $networkId;
    /**
     * The rating of this series (ages, ...).
     *
     * @var string
     */
    public $rating;
    /**
     * The runtime of a single episode in minutes.
     *
     * @var string
     */
    public $runtime;
    /**
     * The series id. The same as the id?
     *
     * @var int
     */
    public $seriesId;
    /**
     * The rating given by the TVDb users.
     *
     * @var int
     */
    public $siteRating;
    /**
     * The number of people that voted for the rating.
     *
     * @var int
     */
    public $siteRatingCount;
    /**
     * The zap2it id of the series.
     *
     * @var string
     */
    public $zap2itId;
}
