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
    public function testGetSerieById()
    {
        $series_id = 1337;
        $overview = 'foo bar baz';
        $this->parent->expects(static::once())->method('performAPICallWithJsonResponse')->with(
            static::equalTo('get'),
            static::equalTo('/series/'.$series_id)
        )->willReturn(['id' => $series_id, 'overview' => $overview]);
        $instance = new SeriesRoute($this->parent);
        $series = $instance->getById($series_id);
        static::assertInstanceOf(SeriesExtendedRecord::class, $series);
        static::assertEquals($series_id, $series->id);
        static::assertEquals($overview, $series->overview);
    }

    public function testGetLastModified()
    {
        $series_id = 1337;
        $last_modified = DateTimeImmutable::createFromMutable(DateTime::createFromFormat('U', '1505036194'));
        $wrong_last = 'fail to parse';
        $this->parent->expects(static::exactly(3))->method('requestHeaders')->with(
            static::equalTo('head'),
            static::equalTo('/series/'.$series_id)
        )->willReturnOnConsecutiveCalls(
            ['Last-Modified' => [$last_modified->format(SeriesRoute::LAST_MODIFIED_FORMAT)]],
            ['Last-Modified' => [$wrong_last]],
            []
        );
        $instance = new SeriesRoute($this->parent);
        $expected_modification = $instance->getLastModified($series_id);
        static::assertEquals($last_modified, $expected_modification);
        // Parse fail
        try {
            $instance->getLastModified($series_id);
            static::fail('No exception thrown');
        } catch (ParseException $e) {
            static::assertEquals(sprintf(ParseException::MODIFIED_MESSAGE, $wrong_last), $e->getMessage());
        } catch (\Exception $e) {
            static::fail('Wrong exception type');
        }
        // Check for missing header
        try {
            $instance->getLastModified($series_id);
            static::fail('No exception thrown');
        } catch (ParseException $e) {
            static::assertEquals(sprintf(ParseException::HEADER_MESSAGE, 'Last-Modified'), $e->getMessage());
        } catch (\Exception $e) {
            static::fail('Wrong exception type');
        }
    }

    public function testGetActorsForSerie()
    {
        $series_id = 1337;
        $this->parent->expects(static::once())->method('performAPICallWithJsonResponse')->with(
            static::equalTo('get'),
            static::equalTo('/series/'.$series_id.'/actors')
        )->willReturn(
            [['id' => 123, 'name' => 'foo bar'], ['id' => 124, 'name' => 'bar baz']]
        );
        $instance = new SeriesRoute($this->parent);
        $actors = $instance->getActors($series_id);
        static::assertContainsOnlyInstancesOf(Actor::class, $actors);
    }

    public function testGetEpisodes()
    {
        $series_id = 1337;
        $page = 1;
        $options = ['query' => ['page' => $page]];
        $this->parent->expects(static::once())->method('performAPICallWithJsonResponse')->with(
            static::equalTo('get'),
            static::equalTo('/series/'.$series_id.'/episodes'),
            static::equalTo($options)
        )->willReturn(
            [['id' => 123, 'name' => 'foo bar'], ['id' => 124, 'name' => 'bar baz']]
        );
        $this->parent->expects(static::once())->method('getLastLinks')->willReturn(
            ['previous' => 0, 'next' => 2, 'first' => 0, 'last' => 1337]
        );
        $instance = new SeriesRoute($this->parent);
        $episodes = $instance->getEpisodes($series_id, $page);
        static::assertInstanceOf(PaginatedResults::class, $episodes);
        static::assertContainsOnlyInstancesOf(EpisodeBaseRecord::class, $episodes->getData());
    }

    public function testGetAllEpisodes()
    {
        $series_id = 1337;
        $mocked_method = 'getEpisodes';
        $mock = $this->getMockBuilder(SeriesRoute::class)
            ->setConstructorArgs([$this->parent])
            ->onlyMethods([$mocked_method])
            ->getMock();
        $mock->expects(static::exactly(5))->method($mocked_method)->withConsecutive(
            [$series_id, 1],
            [$series_id, 2],
            [$series_id, 3],
            [$series_id, 4],
            [$series_id, 5]
        )->willReturnOnConsecutiveCalls(
            new PaginatedResults(
                [new EpisodeBaseRecord(), new EpisodeBaseRecord()], ['previous' => 0, 'next' => 2, 'first' => 0, 'last' => 5]),
            new PaginatedResults(
                [new EpisodeBaseRecord(), new EpisodeBaseRecord()], ['previous' => 1, 'next' => 3, 'first' => 0, 'last' => 5]),
            new PaginatedResults(
                [new EpisodeBaseRecord(), new EpisodeBaseRecord()], ['previous' => 2, 'next' => 4, 'first' => 0, 'last' => 5]),
            new PaginatedResults(
                [new EpisodeBaseRecord(), new EpisodeBaseRecord()], ['previous' => 3, 'next' => 5, 'first' => 0, 'last' => 5]),
            new PaginatedResults([new EpisodeBaseRecord()], ['previous' => 4, 'next' => 0, 'first' => 0, 'last' => 5])
        );

        $episodes = $mock->getAllEpisodes($series_id);
        static::assertCount(9, $episodes);
        static::assertContainsOnlyInstancesOf(EpisodeBaseRecord::class, $episodes);
    }

    public function testGetEpisodeQueryParams()
    {
        $series_id = 1337;
        $parameters = ['foo', 'bar', 'baz'];
        $this->parent->expects(static::once())->method('performAPICallWithJsonResponse')->with(
            static::equalTo('get'),
            static::equalTo('/series/'.$series_id.'/episodes/query/params')
        )->willReturn($parameters);
        $instance = new SeriesRoute($this->parent);
        $query_params = $instance->getEpisodesQueryParams($series_id);
        static::assertEquals($parameters, $query_params);
    }

    public function testGetFilteredEpisodes()
    {
        $series_id = 1337;
        $parameters = ['foo', 'bar', 'baz'];
        $options = ['query' => $parameters];
        $this->parent->expects(static::once())->method('performAPICallWithJsonResponse')->with(
            static::equalTo('get'),
            static::equalTo('/series/'.$series_id.'/episodes/query'),
            static::equalTo($options)
        )->willReturn(
            [['id' => 123, 'name' => 'foo bar'], ['id' => 124, 'name' => 'bar baz']]
        );
        $this->parent->expects(static::once())->method('getLastLinks')->willReturn(
            ['previous' => 0, 'next' => 2, 'first' => 0, 'last' => 1337]
        );
        $instance = new SeriesRoute($this->parent);
        $episodes = $instance->getEpisodesWithQuery($series_id, $parameters);
        static::assertInstanceOf(PaginatedResults::class, $episodes);
        static::assertContainsOnlyInstancesOf(EpisodeBaseRecord::class, $episodes->getData());
    }

    public function testGetEpisodeSummary()
    {
        $series_id = 1337;
        $this->parent->expects(static::once())->method('performAPICallWithJsonResponse')->with(
            static::equalTo('get'),
            static::equalTo('/series/'.$series_id.'/episodes/summary')
        )->willReturn(['airedSeasons' => ["0", "1"]]);
        $instance = new SeriesRoute($this->parent);
        $stats = $instance->getEpisodesSummary($series_id);
        static::assertInstanceOf(SeriesStatistics::class, $stats);
    }

    public function testGetFilterParams()
    {
        $series_id = 1337;
        $parameters = ['foo', 'bar', 'baz'];
        $this->parent->expects(static::once())->method('performAPICallWithJsonResponse')->with(
            static::equalTo('get'),
            static::equalTo('/series/'.$series_id.'/filter/params')
        )->willReturn($parameters);
        $instance = new SeriesRoute($this->parent);
        $query_params = $instance->getFilterParams($series_id);
        static::assertEquals($parameters, $query_params);
    }

    public function testGetFiltered()
    {
        $series_id = 1337;
        $parameters = ['foo', 'bar', 'baz'];
        $this->parent->expects(static::once())->method('performAPICallWithJsonResponse')->with(
            static::equalTo('get'),
            static::equalTo('/series/'.$series_id.'/filter'),
            ['query' => ['keys' => join(',', $parameters)]]
        )->willReturn($parameters);
        $instance = new SeriesRoute($this->parent);
        $query_params = $instance->getWithFilter($series_id, $parameters);
        static::assertEquals($parameters, $query_params);
    }

    public function testGetImages()
    {
        $series_id = 1337;
        $this->parent->expects(static::once())->method('performAPICallWithJsonResponse')->with(
            static::equalTo('get'),
            static::equalTo('/series/'.$series_id.'/images')
        )->willReturn(['fanart' => 1]);
        $instance = new SeriesRoute($this->parent);
        $image_stats = $instance->getImages($series_id);
        static::assertInstanceOf(ImageStatistics::class, $image_stats);
    }

    public function testGetQueryParamsForImages()
    {
        $series_id = 1337;
        $parameters = [['keyType' => 'foo'], ['keyType' => 'bar']];
        $this->parent->expects(static::once())->method('performAPICallWithJsonResponse')->with(
            static::equalTo('get'),
            static::equalTo('/series/'.$series_id.'/images/query/params')
        )->willReturn($parameters);
        $instance = new SeriesRoute($this->parent);
        $query_params = $instance->getImagesQueryParams($series_id);
        static::assertContainsOnlyInstancesOf(ImageQueryParams::class, $query_params);
    }

    public function testObtainImagesWithQuery()
    {
        $series_id = 1337;
        $parameters = ['foo' => 'bar'];
        $this->parent->expects(static::once())->method('performAPICallWithJsonResponse')->with(
            static::equalTo('get'),
            static::equalTo('/series/'.$series_id.'/images/query'),
            ['query' => $parameters]
        )->willReturn(
            [['resolution' => '1920x1080'], ['resolution' => '1920x1080']]
        );
        $instance = new SeriesRoute($this->parent);
        $images = $instance->getImagesWithQuery($series_id, $parameters);
        static::assertContainsOnlyInstancesOf(Image::class, $images);
    }
}
