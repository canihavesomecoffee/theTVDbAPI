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
 * Represents rating info on TVDb.
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

use InvalidArgumentException;

/**
 * Class Rating
 *
 * @category TheTVDbAPI
 * @package  CanIHaveSomeCoffee\TheTVDbAPI\Model
 * @author   Willem Van Iseghem (canihavesomecoffee) <theTVDbAPI@canihavesome.coffee>
 * @license  See start of document
 * @link     https://canihavesome.coffee/projects/theTVDbAPI
 */
class Rating
{
    /**
     * Rating type for series.
     */
    const RATING_TYPE_SERIES = 'series';
    /**
     * Rating type for episodes.
     */
    const RATING_TYPE_EPISODE = 'episode';
    /**
     * Rating type for banners.
     */
    const RATING_TYPE_BANNER = 'banner';

    /**
     * All the above constants together.
     *
     * @var array
     */
    private static $ratingTypes = [
        self::RATING_TYPE_SERIES,
        self::RATING_TYPE_EPISODE,
        self::RATING_TYPE_BANNER,
    ];

    /**
     * The rating
     *
     * @var integer
     */
    public $rating;
    /**
     * The rating item id.
     *
     * @var integer
     */
    public $ratingItemId;
    /**
     * The rating type.
     *
     * @var string
     */
    private $ratingType = '';


    /**
     * Rating constructor.
     *
     * @param int    $rating       The given rating.
     * @param int    $ratingItemId The id of the rated item.
     * @param string $ratingType   The rating type.
     */
    public function __construct($rating, $ratingItemId, $ratingType)
    {
        $this->rating       = $rating;
        $this->ratingItemId = $ratingItemId;
        $this->setRatingType($ratingType);
    }


    /**
     * Gets the RatingTye
     *
     * @return string
     */
    public function getRatingType(): string
    {
        return $this->ratingType;
    }

    /**
     * Sets RatingTye
     *
     * @param string $ratingType Must be one of the valid rating types.
     *
     * @return string The previous value
     */
    public function setRatingType(string $ratingType): string
    {
        if (static::isValidRatingType($ratingType) === false) {
            throw new InvalidArgumentException('Invalid rating type');
        }
        $previous         = $this->ratingType;
        $this->ratingType = $ratingType;

        return $previous;
    }

    /**
     * Checks if a given rating type is valid.
     *
     * @param string $ratingType The rating type to check.
     *
     * @return bool
     */
    public static function isValidRatingType(string $ratingType): bool
    {
        return in_array($ratingType, static::$ratingTypes, true);
    }
}
