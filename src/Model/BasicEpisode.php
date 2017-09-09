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
 * Provides a class with the minimal data an episode contains.
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
 * Class BasicEpisode
 *
 * @category TheTVDbAPI
 * @package  CanIHaveSomeCoffee\TheTVDbAPI\Model
 * @author   Willem Van Iseghem (canihavesomecoffee) <theTVDbAPI@canihavesome.coffee>
 * @license  See start of document
 * @link     https://canihavesome.coffee/projects/theTVDbAPI
 */
class BasicEpisode
{
    /**
     * TVDb episode id.
     *
     * @var int
     */
    public $id;
    /**
     * Absolute episode number for series.
     *
     * @var int
     */
    public $absoluteNumber;
    /**
     * Aired season relative episode number.
     *
     * @var int
     */
    public $airedEpisodeNumber;
    /**
     * Aired season number.
     *
     * @var int
     */
    public $airedSeason;
    /**
     * DVD season relative episode number.
     *
     * @var int
     */
    public $dvdEpisodeNumber;
    /**
     * DVD season number.
     *
     * @var int
     */
    public $dvdSeason;
    /**
     * Episode name.
     *
     * @var string
     */
    public $episodeName;
    /**
     * Episode short description.
     *
     * @var string
     */
    public $overview;
    /**
     * Y-m-d string value of first time the episode aired.
     *
     * @var string
     */
    public $firstAired;
    /**
     * Unix timestamp of last update.
     *
     * @var int
     */
    public $lastUpdated;
}
