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
 * Class SeriesExtendedRecord
 *
 * @category TheTVDbAPI
 * @package  CanIHaveSomeCoffee\TheTVDbAPI\Model
 * @author   Willem Van Iseghem (canihavesomecoffee) <theTVDbAPI@canihavesome.coffee>
 * @license  See start of document
 * @link     https://canihavesome.coffee/projects/theTVDbAPI
 */
class SeriesExtendedRecord extends SeriesBaseRecord
{
    /**
     * Which days the series airs.
     *
     * @var SeriesAirsDays
     */
    public SeriesAirsDays $airsDays;
    /**
     * Time when the series airs.
     *
     * @var string|null
     */
    public ?string $airsTime;
    /**
     * Time when the series airs in UTC.
     *
     * @var string|null
     */
    public ?string $airsTimeUTC;
    /**
     * Artworks for this series.
     *
     * @var ArtworkBaseRecord[]
     */
    public array $artworks;
    /**
     * Characters for this series.
     *
     * @var Character[]
     */
    public array $characters;
    /**
     * Genres for this series.
     *
     * @var GenreBaseRecord[]
     */
    public array $genres;
    /**
     * List of remote id's for this series.
     *
     * @var RemoteID[]
     */
    public array $remoteIds;
    /**
     * List of seasons for this series.
     *
     * @var SeasonBaseRecord[]
     */
    public array $seasons;
    /**
     * List of trailers for this series.
     *
     * @var Trailer[]
     */
    public array $trailers;
    /**
     * List of companies for this series.
     *
     * @var Company[]
     */
    public array $companies;
    /**
     * THe original network.
     *
     * @var Company
     */
    public Company $originalNetwork;
    /**
     * THe latest network.
     *
     * @var Company
     */
    public Company $latestNetwork;
    /**
     * Translations.
     *
     * @var TranslationExtended[]|null
     */
    public ?array $translations;
    /**
     * Tags.
     *
     * @var TagOption[]|null
     */
    public ?array $tags;
    /**
     * Content ratings this series received.
     *
     * @var ContentRating[]|null
     */
    public ?array $contentRatings;
    /**
     * The overview if provided.
     *
     * @var string|null
     */
    public ?string $overview;
    /**
     * Season types.
     *
     * @var SeasonType[]
     */
    public array $seasonTypes;


    /**
     * Filters the remote id's for the IMDB id (if available).
     *
     * @return string|null
     */
    public function getIMDBId(): ?string
    {
        foreach ($this->remoteIds as $remoteId) {
            if ($remoteId->type === 2) {
                return $remoteId->id;
            }
        }
        return null;
    }


}
