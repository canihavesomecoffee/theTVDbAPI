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
 * Route that exposes the users methods of TheTVDb API.
 *
 * PHP version 7.1
 *
 * @category TheTVDbAPI
 * @package  CanIHaveSomeCoffee\TheTVDbAPI\Route
 * @author   Willem Van Iseghem (canihavesomecoffee) <theTVDbAPI@canihavesome.coffee>
 * @license  See start of document
 * @link     https://canihavesome.coffee/projects/theTVDbAPI
 */
declare(strict_types = 1);

namespace CanIHaveSomeCoffee\TheTVDbAPI\Route;

use CanIHaveSomeCoffee\TheTVDbAPI\DataParser;
use CanIHaveSomeCoffee\TheTVDbAPI\Model\PaginatedResults;
use CanIHaveSomeCoffee\TheTVDbAPI\Model\Rating;
use CanIHaveSomeCoffee\TheTVDbAPI\Model\UserData;
use InvalidArgumentException;

/**
 * Class UsersRoute
 *
 * @category TheTVDbAPI
 * @package  CanIHaveSomeCoffee\TheTVDbAPI\Route
 * @author   Willem Van Iseghem (canihavesomecoffee) <theTVDbAPI@canihavesome.coffee>
 * @license  See start of document
 * @link     https://canihavesome.coffee/projects/theTVDbAPI
 */
class UsersRoute extends AbstractRoute
{


    /**
     * Get basic information about the currently authenticated user.
     *
     * @return UserData The user information about the user.
     */
    public function getUserData(): UserData
    {
        $json = $this->parent->performAPICallWithJsonResponse('get', '/user');
        return DataParser::parseData($json, UserData::class);
    }

    /**
     * Get user favorites.
     *
     * @return array An array with the user's favourites.
     */
    public function getFavorites(): array
    {
        $json = $this->parent->performAPICallWithJsonResponse('get', '/user/favorites');
        return $json['favorites'];
    }

    /**
     * Remove series from favorites.
     *
     * @param int $seriesId The id of the series to remove.
     *
     * @return bool True if the series was removed from the user's favourites.
     */
    public function removeFavorite(int $seriesId): bool
    {
        $response = $this->parent->performAPICall('delete', '/user/favorites/'.$seriesId);
        return $response->getStatusCode() === 200;
    }

    /**
     * Add series to favorites.
     *
     * @param int $seriesId The id of the series to add.
     *
     * @return array An array with the user's favourites.
     */
    public function addFavorite(int $seriesId): array
    {
        $json = $this->parent->performAPICallWithJsonResponse('put', '/user/favorites/'.$seriesId);
        return $json['favorites'];
    }

    /**
     * Get user ratings.
     *
     * @param string $type The type of rating to retrieve. If none is specified, all ratings will be returned.
     *
     * @return PaginatedResults
     */
    public function getRatings(string $type = null): PaginatedResults
    {
        if ($type !== null) {
            if (Rating::isValidRatingType($type) === false) {
                throw new InvalidArgumentException('Invalid rating type');
            }
            $json = $this->parent->performAPICallWithJsonResponse(
                'get',
                '/user/ratings/query',
                ['query' => ['itemType' => $type]]
            );
        } else {
            $json = $this->parent->performAPICallWithJsonResponse('get', '/user/ratings');
        }

        return new PaginatedResults(DataParser::parseDataArray($json, Rating::class), $this->parent->getLastLinks());
    }

    /**
     * Adds a user rating.
     *
     * @param Rating $rating The rating to add.
     *
     * @return bool True on success, false on failure.
     */
    public function addRating(Rating $rating): bool
    {
        $response = $this->parent->performAPICall(
            'put',
            'user/ratings/'.$rating->getRatingType().'/'.$rating->ratingItemId.'/'.$rating->rating
        );
        return $response->getStatusCode() === 200;
    }

    /**
     * Update user rating.
     *
     * @param Rating $rating The rating to add.
     *
     * @return bool True on success, false on failure.
     */
    public function updateRating(Rating $rating): bool
    {
        return $this->addRating($rating);
    }

    /**
     * Remove user rating.
     *
     * @param Rating $rating The rating to add.
     *
     * @return bool True on success, false on failure.
     */
    public function removeRating(Rating $rating)
    {
        $response = $this->parent->performAPICall(
            'delete',
            'user/ratings/'.$rating->getRatingType().'/'.$rating->ratingItemId
        );
        return $response->getStatusCode() === 200;
    }
}
