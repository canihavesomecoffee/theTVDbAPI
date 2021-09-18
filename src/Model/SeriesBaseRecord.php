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
 * Provides a class with the minimal data a serie contains.
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
class SeriesBaseRecord
{
    /**
     * The abbreviation for this series.
     *
     * @var string
     */
    public string $abbreviation;
    /**
     * The known aliases for this serie.
     *
     * @var array
     */
    public array $aliases;
    /**
     * The country of the serie.
     *
     * @var string
     */
    public string $country;
    /**
     * The default season type.
     *
     * @var integer
     */
    public int $defaultSeasonType;
    /**
     * The Y-M-D representation of the first time the show aired.
     *
     * @var string|null
     */
    public ?string $firstAired;
    /**
     * The id of the serie.
     *
     * @var integer
     */
    public int $id;
    /**
     * The image related to this series.
     *
     * @var string|null
     */
    public ?string $image;
    /**
     * Is the order for this series randomized?
     *
     * @var boolean
     */
    public bool $isOrderRandomized;
    /**
     * The last date the series was aired on.
     *
     * @var string|null
     */
    public ?string $lastAired;
    /**
     * The name of the serie.
     *
     * @var string
     */
    public string $name;
    /**
     * List of languages for which translated series names are available.
     *
     * @var array
     */
    public array $nameTranslations;
    /**
     * The next air date.
     *
     * @var string
     */
    public string $nextAired;
    /**
     * Original country this series was shown in.
     *
     * @var string|null
     */
    public ?string $originalCountry;
    /**
     * Original language of the series.
     *
     * @var string
     */
    public string $originalLanguage;
    /**
     * The score of this series.
     *
     * @var float|integer
     */
    public float $score;
    /**
     * The slug of the serie.
     *
     * @var string|null
     */
    public $slug;
    /**
     * The status of the serie.
     *
     * @var Status
     */
    public Status $status;
}
