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
 * Class PeopleExtendedRecord
 *
 * @package CanIHaveSomeCoffee\TheTVDbAPI\Model
 */
class PeopleExtendedRecord extends PeopleBaseRecord
{
    /**
     * The awards of this person.
     *
     * @var array
     */
    public array $awards;
    /**
     * The biographies of this person.
     *
     * @var array
     */
    public array $biographies;
    /**
     * The birth date of this person.
     *
     * @var string
     */
    public string $birth;
    /**
     * The birth place of this person.
     *
     * @var string
     */
    public string $birthPlace;
    /**
     * The awards of this person.
     *
     * @var array
     */
    public array $characters;
    /**
     * The death date of this person.
     *
     * @var string
     */
    public string $death;
    /**
     * The gender of this person.
     *
     * @var integer|float|null
     */
    public $gender;
    /**
     * The races of this person.
     *
     * @var array
     */
    public array $races;
    /**
     * The remote ID's of this person.
     *
     * @var array
     */
    public array $remoteIds;
    /**
     * The tag options of this person.
     *
     * @var array
     */
    public array $tagOptions;
}
