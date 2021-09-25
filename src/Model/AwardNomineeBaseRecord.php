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
 * Provides a class with the base record for an award nominee.
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
 * Class AwardNomineeBaseRecord
 *
 * @category TheTVDbAPI
 * @package  CanIHaveSomeCoffee\TheTVDbAPI\Model
 * @author   Willem Van Iseghem (canihavesomecoffee) <theTVDbAPI@canihavesome.coffee>
 * @license  See start of document
 * @link     https://canihavesome.coffee/projects/theTVDbAPI
 */
class AwardNomineeBaseRecord
{
    /**
     * The linked actor.
     *
     * @var Character
     */
    public Character $character;
    /**
     * Details on this nomination.
     *
     * @var string
     */
    public string $details;
    /**
     * Linked episode to this nomination.
     *
     * @var EpisodeBaseRecord|null
     */
    public ?EpisodeBaseRecord $episode;
    /**
     * The id of this nomination.
     *
     * @var integer
     */
    public int $id;
    /**
     * Did they win the nomination?
     *
     * @var boolean
     */
    public bool $isWinner;
    /**
     * Linked movie to this nomination.
     *
     * @var MovieBaseRecord|null
     */
    public ?MovieBaseRecord $movie;
    /**
     * Linked series to this nomination.
     *
     * @var SeriesBaseRecord|null
     */
    public ?SeriesBaseRecord $series;
    /**
     * The year of the nomination.
     *
     * @var string
     */
    public string $year;
    /**
     * The category of the nomination.
     *
     * @var string
     */
    public string $category;
    /**
     * The name of the nomination.
     *
     * @var string
     */
    public string $name;


}
