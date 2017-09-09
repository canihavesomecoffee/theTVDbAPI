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
 * Provides a full episode object.
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
 * Class Episode
 *
 * @category TheTVDbAPI
 * @package  CanIHaveSomeCoffee\TheTVDbAPI\Model
 * @author   Willem Van Iseghem (canihavesomecoffee) <theTVDbAPI@canihavesome.coffee>
 * @license  See start of document
 * @link     https://canihavesome.coffee/projects/theTVDbAPI
 */
class Episode extends BasicEpisode
{
    /**
     * A list of guest stars (by name).
     *
     * @var array
     */
    public $guestStars = [];
    /**
     * A list of directors (by name).
     *
     * @var array
     */
    public $directors = [];
    /**
     * A list of writers (by name).
     *
     * @var array
     */
    public $writers = [];
    /**
     * The production code of this episode.
     *
     * @var string
     */
    public $productionCode;
    /**
     * A link to the website of the show.
     *
     * @var string
     */
    public $showUrl;
    /**
     * The id of the DVD disc.
     *
     * @var string
     */
    public $dvdDiscid;
    /**
     * The chapter number on the DVD.
     *
     * @var float
     */
    public $dvdChapter;
    /**
     * The filename on the disc?
     *
     * @var string
     */
    public $filename;
    /**
     * The TVDb id of the series.
     *
     * @var int
     */
    public $seriesId;
    /**
     * The user that last updated this episode.
     *
     * @var string
     */
    public $lastUpdatedBy;
    /**
     * Indicates if the special aired after said season.
     *
     * @var int
     */
    public $airsAfterSeason;
    /**
     * Indicates if the special aired before said season.
     *
     * @var int
     */
    public $airsBeforeSeason;
    /**
     * Indicates if a special aired before a certain episode.
     *
     * @var int
     */
    public $airsBeforeEpisode;
    /**
     * User id of the author of the thumbnail.
     *
     * @var int
     */
    public $thumbAuthor;
    /**
     * Y-m-d of the time when the thumbnail was added.
     *
     * @var string
     */
    public $thumbAdded;
    /**
     * The width of the thumbnail in pixels.
     *
     * @var int
     */
    public $thumbWidth;
    /**
     * Height of thumbnail in pixels.
     *
     * @var int
     */
    public $thumbHeight;
    /**
     * The IMDB id for this episode.
     *
     * @var string
     */
    public $imdbId;
    /**
     * The average rating on TVDb for this episode.
     *
     * @var float
     */
    public $siteRating;
    /**
     * The amount of persons that voted.
     *
     * @var int
     */
    public $siteRatingCount;


    /**
     * Gets the first director.
     *
     * @return string The first director, or an empty string if no directors are known.
     */
    public function getDirector()
    {
        if (sizeof($this->directors) > 0) {
            return $this->directors[0];
        }
        return "";
    }

    /**
     * Adds a director to the list of directors.
     *
     * @param string $director The director to add.
     *
     * @return void
     */
    public function setDirector($director)
    {
        $this->directors[] = $director;
    }
}
