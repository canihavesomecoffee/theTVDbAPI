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
 */

declare(strict_types=1);

namespace CanIHaveSomeCoffee\TheTVDbAPI\Tests\Route;

use CanIHaveSomeCoffee\TheTVDbAPI\Model\PaginatedResults;
use CanIHaveSomeCoffee\TheTVDbAPI\Model\Rating;
use CanIHaveSomeCoffee\TheTVDbAPI\Model\UserData;
use CanIHaveSomeCoffee\TheTVDbAPI\Route\UsersRoute;
use GuzzleHttp\Psr7\Response;
use InvalidArgumentException;

/**
 * Class UsersRouteTest
 *
 * @category TheTVDbAPI
 * @package  CanIHaveSomeCoffee\TheTVDbAPI\Tests
 * @author   Willem Van Iseghem (canihavesomecoffee) <theTVDbAPI@canihavesome.coffee>
 * @license  See start of document
 * @link     https://canihavesome.coffee/projects/theTVDbAPI
 */
class UsersRouteTest extends BaseRouteTest
{


    public function testRetrieveUserData()
    {
        $this->parent->expects(static::exactly(1))->method('performAPICallWithJsonResponse')->with(
            static::equalTo('getUserData'),
            static::equalTo('/user')
        )->willReturn(['favoritesDisplaymode' => 'foo', 'language' => 'en', 'userName' => 'foo_bar']);
        $instance = new UsersRoute($this->parent);
        $data = $instance->getUserData();
        static::assertInstanceOf(UserData::class, $data);
    }

    public function testRetrieveUserFavourites()
    {
        $favourites = ['123', '124', '9999'];
        $this->parent->expects(static::exactly(1))->method('performAPICallWithJsonResponse')->with(
            static::equalTo('getUserData'),
            static::equalTo('/user/favorites')
        )->willReturn(['favorites' => $favourites]);
        $instance = new UsersRoute($this->parent);
        $data = $instance->getFavorites();
        static::assertEquals($favourites, $data);
    }

    public function testDeleteFavourite()
    {
        $id = 123;
        $this->parent->expects(static::exactly(1))->method('performAPICall')->with(
            static::equalTo('delete'),
            static::equalTo('/user/favorites/'.$id)
        )->willReturn(new Response());
        $instance = new UsersRoute($this->parent);
        static::assertTrue($instance->removeFavorite($id));
    }

    public function testAddFavourite()
    {
        $id = 123;
        $favourites = ['123', '124', '9999'];
        $this->parent->expects(static::exactly(1))->method('performAPICallWithJsonResponse')->with(
            static::equalTo('put'),
            static::equalTo('/user/favorites/'.$id)
        )->willReturn(['favorites' => $favourites]);
        $instance = new UsersRoute($this->parent);
        $data = $instance->addFavorite($id);
        static::assertEquals($favourites, $data);
    }

    public function testRetrieveAllRatings()
    {
        $this->parent->expects(static::once())->method('performAPICallWithJsonResponse')->with(
            static::equalTo('getUserData'),
            static::equalTo('/user/ratings')
        )->willReturn(
            [
                ['rating' => 10, 'ratingItemId' => 123, 'ratingType' => Rating::RATING_TYPE_SERIES],
                ['rating' => 5, 'ratingItemId' => 124, 'ratingType' => Rating::RATING_TYPE_SERIES]
            ]
        );
        $this->parent->expects(static::once())->method('getLastLinks')->willReturn(
            ['previous' => 0, 'next' => 2, 'first' => 0, 'last' => 2]
        );
        $instance = new UsersRoute($this->parent);
        $data = $instance->getRatings();
        static::assertInstanceOf(PaginatedResults::class, $data);
        static::assertContainsOnlyInstancesOf(Rating::class, $data->getData());
    }

    public function testRetrieveRatingsWithWrongType()
    {
        static::expectExceptionMessage('Invalid rating type');
        static::expectException(InvalidArgumentException::class);
        $instance = new UsersRoute($this->parent);
        $instance->getRatings('foo');
    }

    public function testRetrieveSeriesRatings()
    {
        $this->parent->expects(static::once())->method('performAPICallWithJsonResponse')->with(
            static::equalTo('getUserData'),
            static::equalTo('/user/ratings/query'),
            static::equalTo(['query' => ['itemType' => Rating::RATING_TYPE_SERIES]])
        )->willReturn(
            [
                ['rating' => 10, 'ratingItemId' => 123, 'ratingType' => Rating::RATING_TYPE_SERIES],
                ['rating' => 5, 'ratingItemId' => 124, 'ratingType' => Rating::RATING_TYPE_SERIES]
            ]
        );
        $this->parent->expects(static::once())->method('getLastLinks')->willReturn(
            ['previous' => 0, 'next' => 2, 'first' => 0, 'last' => 2]
        );
        $instance = new UsersRoute($this->parent);
        $data = $instance->getRatings(Rating::RATING_TYPE_SERIES);
        static::assertInstanceOf(PaginatedResults::class, $data);
        static::assertContainsOnlyInstancesOf(Rating::class, $data->getData());
    }

    public function testAddRating()
    {
        $rating = new Rating(10, 123, Rating::RATING_TYPE_SERIES);
        $this->parent->expects(static::once())->method('performAPICall')->with(
            static::equalTo('put'),
            static::equalTo('user/ratings/'.$rating->getRatingType().'/'.$rating->ratingItemId.'/'.$rating->rating)
        )->willReturn(new Response());
        $instance = new UsersRoute($this->parent);
        static::assertTrue($instance->addRating($rating));
    }

    public function testUpdateRating()
    {
        $rating = new Rating(10, 123, Rating::RATING_TYPE_SERIES);
        $this->parent->expects(static::once())->method('performAPICall')->with(
            static::equalTo('put'),
            static::equalTo('user/ratings/'.$rating->getRatingType().'/'.$rating->ratingItemId.'/'.$rating->rating)
        )->willReturn(new Response());
        $instance = new UsersRoute($this->parent);
        static::assertTrue($instance->updateRating($rating));
    }

    public function testRemoveRating()
    {
        $rating = new Rating(10, 123, Rating::RATING_TYPE_SERIES);
        $this->parent->expects(static::once())->method('performAPICall')->with(
            static::equalTo('delete'),
            static::equalTo('user/ratings/'.$rating->getRatingType().'/'.$rating->ratingItemId)
        )->willReturn(new Response());
        $instance = new UsersRoute($this->parent);
        static::assertTrue($instance->removeRating($rating));
    }
}
