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
 * Provides a class with the data artwork type contains.
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
 * Class ArtworkType
 *
 * @category TheTVDbAPI
 * @package  CanIHaveSomeCoffee\TheTVDbAPI\Model
 * @author   Willem Van Iseghem (canihavesomecoffee) <theTVDbAPI@canihavesome.coffee>
 * @license  See start of document
 * @link     https://canihavesome.coffee/projects/theTVDbAPI
 */
class ArtworkType
{
    /**
     * The height of this artwork type.
     *
     * @var integer
     */
    public int $height;
    /**
     * The ID of the artwork type.
     *
     * @var integer
     */
    public int $id;
    /**
     * The file type of the artwork type. I.e. PNG, JPG, ...
     *
     * @var string
     */
    public string $imageFormat;
    /**
     * The name of the artwork type.
     *
     * @var string
     */
    public string $name;
    /**
     * The associated record for this artwork type.
     *
     * @var string
     */
    public string $recordType;
    /**
     * The slug for this type of artwork.
     *
     * @var string
     */
    public string $slug;
    /**
     * The height of the thumbnail for this artwork type.
     *
     * @var integer
     */
    public int $thumbnailHeight;
    /**
     * The width of the thumbnail for this artwork type.
     *
     * @var integer
     */
    public int $thumbnailWidth;
    /**
     * The width of this artwork type.
     *
     * @var integer
     */
    public int $width;
}
