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
 * Class that represents a tag option.
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
 * Class TagOption
 *
 * @package CanIHaveSomeCoffee\TheTVDbAPI\Model
 */
class TagOption
{
    /**
     * Text associated to this tag option?
     *
     * @var string|null
     */
    public ?string $helpText;
    /**
     * The id for this TagOption.
     *
     * @var integer
     */
    public int $id;
    /**
     * The name for this TagOption.
     *
     * @var string
     */
    public string $name;
    /**
     * Id of the Tag.
     *
     * @var integer
     */
    public int $tag;
    /**
     * Name of the tag.
     *
     * @var string
     */
    public string $tagName;
}
