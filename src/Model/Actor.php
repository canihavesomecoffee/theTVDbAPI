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
 * Provides a class with the data an actor contains.
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
 * Class Actor
 *
 * @category TheTVDbAPI
 * @package  CanIHaveSomeCoffee\TheTVDbAPI\Model
 * @author   Willem Van Iseghem (canihavesomecoffee) <theTVDbAPI@canihavesome.coffee>
 * @license  See start of document
 * @link     https://canihavesome.coffee/projects/theTVDbAPI
 */
class Actor
{
    /**
     * The id of the actor.
     *
     * @var integer
     */
    public $id;
    /**
     * The URL to the image of the actor.
     *
     * @var string
     */
    public $image;
    /**
     * The timestamp when the image was added.
     *
     * @var string
     */
    public $imageAdded;
    /**
     * The id of the author that added the image.
     *
     * @var integer|null
     */
    public $imageAuthor;
    /**
     * The time this entry was last updated
     *
     * @var string
     */
    public $lastUpdated;
    /**
     * The name of the actor.
     *
     * @var string
     */
    public $name;
    /**
     * The role the actor is playing.
     *
     * @var string
     */
    public $role;
    /**
     * The id of the series.
     *
     * @var integer
     */
    public $seriesId;
    /**
     * The sort order of the actors?
     *
     * @var integer
     */
    public $sortOrder;
}
