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
 * Class MovieExtendedRecord
 *
 * @package CanIHaveSomeCoffee\TheTVDbAPI\Model
 */
class MovieExtendedRecord extends MovieBaseRecord
{
    /**
     * Artworks for this movie.
     *
     * @var ArtworkBaseRecord[]
     */
    public array $artworks;
    /**
     * Audio languages for this movie.
     *
     * @var string[]
     */
    public array $audioLanguages;
    /**
     * Awards for this movie.
     *
     * @var AwardBaseRecord[]
     */
    public array $awards;
    /**
     * Box office for this movie.
     *
     * @var string
     */
    public string $boxOffice;
    /**
     * Budget for this movie.
     *
     * @var string
     */
    public string $budget;
    /**
     * Characters for this movie.
     *
     * @var Character[]
     */
    public array $characters;
    /**
     * Genres for this movie.
     *
     * @var GenreBaseRecord[]
     */
    public array $genres;
    /**
     * Original country this movie was shown in.
     *
     * @var string
     */
    public string $originalCountry;
    /**
     * Original language of the movie.
     *
     * @var string
     */
    public string $originalLanguage;
    /**
     * Releases for this movie.
     *
     * @var Release[]
     */
    public array $releases;
    /**
     * External ID's for this movie.
     *
     * @var RemoteID[]
     */
    public array $remoteIds;
    /**
     * Studios for this movie.
     *
     * @var StudioBaseRecord[]|null
     */
    public ?array $studios;
    /**
     * Subtitle languages for this movie.
     *
     * @var string[]
     */
    public array $subtitleLanguages;
    /**
     * Trailers for this movie.
     *
     * @var Trailer[]
     */
    public array $trailers;
    /**
     * List of companies.
     *
     * @var Companies
     */
    public Companies $companies;
    /**
     * Content ratings.
     *
     * @var ContentRating[]|null
     */
    public ?array $contentRatings;
    /**
     * First release info.
     *
     * @var Release
     */
    public Release $first_release;
    /**
     * Inspirations?
     *
     * @var Inspiration[]|null
     */
    public ?array $inspirations;
    /**
     * Production countries.
     *
     * @var ProductionCountry[]|null
     */
    public ?array $production_countries;
    /**
     * Spoken languages.
     *
     * @var string[]|null
     */
    public ?array $spoken_languages;
}
