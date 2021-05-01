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

use CanIHaveSomeCoffee\TheTVDbAPI\Exception\ParseException;
use CanIHaveSomeCoffee\TheTVDbAPI\Model\Actor;
use CanIHaveSomeCoffee\TheTVDbAPI\Model\EpisodeBaseRecord;
use CanIHaveSomeCoffee\TheTVDbAPI\Model\Image;
use CanIHaveSomeCoffee\TheTVDbAPI\Model\ImageQueryParams;
use CanIHaveSomeCoffee\TheTVDbAPI\Model\ImageStatistics;
use CanIHaveSomeCoffee\TheTVDbAPI\Model\PaginatedResults;
use CanIHaveSomeCoffee\TheTVDbAPI\Model\SeriesBaseRecord;
use CanIHaveSomeCoffee\TheTVDbAPI\Model\SeriesExtendedRecord;
use CanIHaveSomeCoffee\TheTVDbAPI\Model\SeriesStatistics;
use CanIHaveSomeCoffee\TheTVDbAPI\Route\SeriesRoute;
use DateTime;
use DateTimeImmutable;

/**
 * Class SearchRouteTest
 *
 * @category TheTVDbAPI
 * @package  CanIHaveSomeCoffee\TheTVDbAPI\Tests
 * @author   Willem Van Iseghem (canihavesomecoffee) <theTVDbAPI@canihavesome.coffee>
 * @license  See start of document
 * @link     https://canihavesome.coffee/projects/theTVDbAPI
 */
class SeriesRouteTest extends BaseRouteTest
{
    public function testSimple()
    {
        $series_id = 1337;
        $overview = 'foo bar baz';
        $this->parent->expects(static::once())->method('performAPICallWithJsonResponse')->with(
            static::equalTo('get'),
            static::equalTo('series/'.$series_id)
        )->willReturn(['id' => $series_id]);
        $instance = new SeriesRoute($this->parent);
        $series = $instance->simple($series_id);
        static::assertInstanceOf(SeriesBaseRecord::class, $series);
        static::assertEquals($series_id, $series->id);
    }

    public function testGetEpisodes()
    {
        $series_id = 1337;
        $page = 1;
        $options = ['query' => ['page' => $page]];
        $this->parent->expects(static::once())->method('performAPICallWithJsonResponse')->with(
            static::equalTo('get'),
            static::equalTo('series/'.$series_id.'/episodes/default'),
            static::equalTo($options)
        )->willReturn(
            ["episodes" => [['id' => 123, 'name' => 'foo bar'], ['id' => 124, 'name' => 'bar baz']]]
        );
        $instance = new SeriesRoute($this->parent);
        $episodes = $instance->episodes($series_id, $page);
        static::assertContainsOnlyInstancesOf(EpisodeBaseRecord::class, $episodes);
    }

    public function testGetAllEpisodes()
    {
        $series_id = 1337;
        $mocked_method = 'episodes';
        $mock = $this->getMockBuilder(SeriesRoute::class)
            ->setConstructorArgs([$this->parent])
            ->onlyMethods([$mocked_method])
            ->getMock();
        $mock->expects(static::exactly(1))->method($mocked_method)->withConsecutive(
            [$series_id, 1]
        )->willReturnOnConsecutiveCalls(
            [new EpisodeBaseRecord(), new EpisodeBaseRecord()]
        );

        $episodes = $mock->allEpisodes($series_id);
        static::assertCount(2, $episodes);
        static::assertContainsOnlyInstancesOf(EpisodeBaseRecord::class, $episodes);
    }
}
