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
 * Tests the SeriesRouteLanguageFallback class.
 *
 * PHP version 7.1
 *
 * @category Tests
 * @package  CanIHaveSomeCoffee\TheTVDbAPI\Tests\MultiLanguageWrapper\Route
 * @author   Willem Van Iseghem (canihavesomecoffee) <theTVDbAPI@canihavesome.coffee>
 * @license  See start of document
 * @link     https://canihavesome.coffee/projects/theTVDbAPI
 */

namespace CanIHaveSomeCoffee\TheTVDbAPI\Tests\MultiLanguageWrapper\Route;

use CanIHaveSomeCoffee\TheTVDbAPI\Model\BasicEpisode;
use CanIHaveSomeCoffee\TheTVDbAPI\Model\Image;
use CanIHaveSomeCoffee\TheTVDbAPI\Model\PaginatedResults;
use CanIHaveSomeCoffee\TheTVDbAPI\Model\Series;
use CanIHaveSomeCoffee\TheTVDbAPI\MultiLanguageWrapper\MultiLanguageFallbackGenerator;
use CanIHaveSomeCoffee\TheTVDbAPI\MultiLanguageWrapper\Route\SeriesRouteLanguageFallback;

/**
 * Tests the SeriesRouteLanguageFallbackTest class.
 *
 * @category Tests
 * @package  CanIHaveSomeCoffee\TheTVDbAPI\Tests\MultiLanguageWrapper\Route
 * @author   Willem Van Iseghem (canihavesomecoffee) <theTVDbAPI@canihavesome.coffee>
 * @license  See start of document
 * @link     https://canihavesome.coffee/projects/theTVDbAPI
 */
class SeriesRouteLanguageFallbackTest extends BaseRouteLanguageFallback
{


    /**
     * Test to check if the closure to retrieve a series by id functions correctly.
     *
     * @return void
     */
    public function testGetClosureById()
    {
        $seriesId = 1337;
        $language = 'en';
        $this->parent->expects(static::once())->method('performAPICallWithJsonResponse')->with(
            static::equalTo('get'),
            static::equalTo('/series/'.$seriesId),
            static::equalTo(['headers' => ['Accept-Language' => $language]])
        )->willReturn(['id' => 123, 'title' => 'foo']);
        $route    = new SeriesRouteLanguageFallback($this->parent);
        $instance = $route->getClosureById($seriesId);
        static::assertInstanceOf(\Closure::class, $instance);
        $return = $instance($language);
        static::assertInstanceOf(Series::class, $return);
    }

    /**
     * Test to check if retrieving a series by id functions correctly.
     *
     * @return void
     */
    public function testRetrieveSeriesById()
    {
        $accepted = ['nl', 'en'];
        $result   = new Series();
        // Mock generator.
        $mockGenerator = $this->createMock(MultiLanguageFallbackGenerator::class);
        $mockGenerator->expects(static::once())->method('create')->with(
            static::isInstanceOf(\Closure::class),
            static::equalTo(Series::class),
            static::equalTo($accepted)
        )->willReturn($result);
        $this->parent->expects(static::once())->method('getAcceptedLanguages')->willReturn($accepted);
        $this->parent->expects(static::once())->method('getGenerator')->willReturn($mockGenerator);
        $instance = new SeriesRouteLanguageFallback($this->parent);
        $return   = $instance->getById(1337);
        static::assertInstanceOf(Series::class, $return);
    }

    /**
     * Test to check if the closure to retrieve episodes for a series functions correctly.
     *
     * @return void
     */
    public function testClosureForEpisodes()
    {
        $seriesId = 1337;
        $options  = ['foo' => 'bar'];
        $language = 'en';
        $this->parent->expects(static::once())->method('performAPICallWithJsonResponse')->with(
            static::equalTo('get'),
            static::equalTo('/series/'.$seriesId.'/episodes'),
            static::equalTo(array_merge(['headers' => ['Accept-Language' => $language]], $options))
        )->willReturn([['id' => 123, 'title' => 'foo']]);
        $route    = new SeriesRouteLanguageFallback($this->parent);
        $instance = $route->getClosureForEpisodes($seriesId, $options);
        static::assertInstanceOf(\Closure::class, $instance);
        $return = $instance($language);
        static::assertTrue(is_array($return));
        static::assertCount(1, $return);
        static::assertContainsOnly(BasicEpisode::class, $return);
    }

    /**
     * Test to check if retrieving episodes for a series functions correctly.
     *
     * @return void
     */
    public function testRetrieveEpisodesForSeries()
    {
        $accepted = ['nl', 'en'];
        $result   = [new BasicEpisode(), new BasicEpisode()];
        // Mock generator.
        $mockGenerator = $this->createMock(MultiLanguageFallbackGenerator::class);
        $mockGenerator->expects(static::once())->method('create')->with(
            static::isInstanceOf(\Closure::class),
            static::equalTo(BasicEpisode::class),
            static::equalTo($accepted)
        )->willReturn($result);
        $this->parent->expects(static::once())->method('getAcceptedLanguages')->willReturn($accepted);
        $this->parent->expects(static::once())->method('getGenerator')->willReturn($mockGenerator);
        $instance = new SeriesRouteLanguageFallback($this->parent);
        $return   = $instance->getEpisodes(1337);
        static::assertInstanceOf(PaginatedResults::class, $return);
        $return = $return->getData();
        static::assertTrue(is_array($return));
        static::assertCount(2, $return);
        static::assertContainsOnly(BasicEpisode::class, $return);
    }

    /**
     * Test to check if the closure to retrieve episodes for a series functions correctly.
     *
     * @return void
     */
    public function testClosureForEpisodesWithQuery()
    {
        $seriesId = 1337;
        $options  = ['foo' => 'bar'];
        $language = 'en';
        $this->parent->expects(static::once())->method('performAPICallWithJsonResponse')->with(
            static::equalTo('get'),
            static::equalTo('/series/'.$seriesId.'/episodes/query'),
            static::equalTo(array_merge(['headers' => ['Accept-Language' => $language]], $options))
        )->willReturn([['id' => 123, 'title' => 'foo']]);
        $route    = new SeriesRouteLanguageFallback($this->parent);
        $instance = $route->getClosureForEpisodesWithQuery($seriesId, $options);
        static::assertInstanceOf(\Closure::class, $instance);
        $return = $instance($language);
        static::assertTrue(is_array($return));
        static::assertCount(1, $return);
        static::assertContainsOnly(BasicEpisode::class, $return);
    }

    /**
     * Test to check if retrieving episodes for a series functions correctly.
     *
     * @return void
     */
    public function testRetrieveEpisodesWithQuery()
    {
        $accepted = ['nl', 'en'];
        $result   = [new BasicEpisode(), new BasicEpisode()];
        // Mock generator.
        $mockGenerator = $this->createMock(MultiLanguageFallbackGenerator::class);
        $mockGenerator->expects(static::once())->method('create')->with(
            static::isInstanceOf(\Closure::class),
            static::equalTo(BasicEpisode::class),
            static::equalTo($accepted)
        )->willReturn($result);
        $this->parent->expects(static::once())->method('getAcceptedLanguages')->willReturn($accepted);
        $this->parent->expects(static::once())->method('getGenerator')->willReturn($mockGenerator);
        $instance = new SeriesRouteLanguageFallback($this->parent);
        $return   = $instance->getEpisodesWithQuery(1337, ['foo' => 'bar']);
        static::assertInstanceOf(PaginatedResults::class, $return);
        $return = $return->getData();
        static::assertTrue(is_array($return));
        static::assertCount(2, $return);
        static::assertContainsOnly(BasicEpisode::class, $return);
    }

    /**
     * Test to check if the closure to retrieve images with a query for a series functions correctly.
     *
     * @return void
     */
    public function testClosureForImagesWithQuery()
    {
        $seriesId = 1337;
        $options  = ['foo' => 'bar'];
        $language = 'en';
        $this->parent->expects(static::once())->method('performAPICallWithJsonResponse')->with(
            static::equalTo('get'),
            static::equalTo('/series/'.$seriesId.'/images/query'),
            static::equalTo(array_merge(['headers' => ['Accept-Language' => $language]], $options))
        )->willReturn([['id' => 123, 'fileName' => 'foo']]);
        $route    = new SeriesRouteLanguageFallback($this->parent);
        $instance = $route->getClosureForImagesWithQuery($seriesId, $options);
        static::assertInstanceOf(\Closure::class, $instance);
        $return = $instance($language);
        static::assertTrue(is_array($return));
        static::assertCount(1, $return);
        static::assertContainsOnly(Image::class, $return);
    }

    /**
     * Test to check if retrieving images with a query for a series functions correctly.
     *
     * @return void
     */
    public function testRetrieveImagesWithQuery()
    {
        $accepted = ['nl', 'en'];
        $result   = [new Image(), new Image()];
        // Mock generator.
        $mockGenerator = $this->createMock(MultiLanguageFallbackGenerator::class);
        $mockGenerator->expects(static::once())->method('create')->with(
            static::isInstanceOf(\Closure::class),
            static::equalTo(BasicEpisode::class),
            static::equalTo($accepted)
        )->willReturn($result);
        $this->parent->expects(static::once())->method('getAcceptedLanguages')->willReturn($accepted);
        $this->parent->expects(static::once())->method('getGenerator')->willReturn($mockGenerator);
        $instance = new SeriesRouteLanguageFallback($this->parent);
        $return   = $instance->getImagesWithQuery(1337, ['foo' => 'bar']);
        static::assertInstanceOf(PaginatedResults::class, $return);
        $return = $return->getData();
        static::assertTrue(is_array($return));
        static::assertCount(2, $return);
        static::assertContainsOnly(Image::class, $return);
    }
}
