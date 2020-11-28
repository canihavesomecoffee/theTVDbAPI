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
 * Provides a class with a search result entry.
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
 * Class SeriesBaseRecord
 *
 * @category TheTVDbAPI
 * @package  CanIHaveSomeCoffee\TheTVDbAPI\Model
 * @author   Willem Van Iseghem (canihavesomecoffee) <theTVDbAPI@canihavesome.coffee>
 * @license  See start of document
 * @link     https://canihavesome.coffee/projects/theTVDbAPI
 */
class SearchResult
{
    /**
     * The known aliases for this serie.
     *
     * @var array
     */
    public array $aliases;
    /**
     * Company names.
     *
     * @var array
     */
    public array $companies;
    /**
     * Company type.
     *
     * @var string
     */
    public string $companyType;
    /**
     * The country of the serie.
     *
     * @var string
     */
    public string $country;
    /**
     * The director.
     *
     * @var string
     */
    public string $director;
    /**
     * The extended title.
     *
     * @var string
     */
    public string $extendedTitle;
    /**
     * Genres.
     *
     * @var array
     */
    public array $genres;
    /**
     * The id
     *
     * @var string
     */
    public string $id;
    /**
     * The image related to this series.
     *
     * @var string
     */
    public string $imageUrl;
    /**
     * The name.
     *
     * @var string
     */
    public string $name;
    /**
     * String with translations
     *
     * @var string
     */
    public string $nameTranslated;
    /**
     * The network
     *
     * @var string
     */
    public string $network;
    /**
     * Overview
     *
     * @var string
     */
    public string $overview;
    /**
     * Translated overviews
     *
     * @var array
     */
    public array $overview_translated;
    /**
     * Posters
     *
     * @var array
     */
    public array $posters;
    /**
     * Original language
     *
     * @var string
     */
    public string $primaryLanguage;
    /**
     * Original type
     *
     * @var string
     */
    public string $primaryType;
    /**
     * The status
     *
     * @var string
     */
    public string $status;
    /**
     * Translations
     *
     * @var array
     */
    public array $translationsWithLang;
    /**
     * TVDb id.
     *
     * @var string
     */
    public string $tvdb_id;
    /**
     * Original type
     *
     * @var string
     */
    public string $type;
    /**
     * The year
     *
     * @var string
     */
    public string $year;

}
