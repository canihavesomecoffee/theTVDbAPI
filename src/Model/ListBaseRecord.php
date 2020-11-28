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
 * Class to represent a list on theTVDb.
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
 * Class ListBaseRecord
 *
 * @package CanIHaveSomeCoffee\TheTVDbAPI\Model
 */
class ListBaseRecord
{
    /**
     * A list of aliases for this list.
     *
     * @var array
     */
    public array $aliases;
    /**
     * The id of this list.
     *
     * @var integer
     */
    public int $id;
    /**
     * Is this an official list?
     *
     * @var boolean
     */
    public bool $isOfficial;
    /**
     * ListBaseRecord name.
     *
     * @var string
     */
    public string $name;
    /**
     * List of languages for which translated list names are available.
     *
     * @var array
     */
    public array $nameTranslations;
    /**
     * An overview of the list.
     *
     * @var string
     */
    public string $overview;
    /**
     * List of languages for which translated list overviews are available.
     *
     * @var array
     */
    public array $overviewTranslations;
    /**
     * The URL where this list can be found.
     *
     * @var string
     */
    public string $url;
}
