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
 * Tests the SearchRouteLanguageFallback class.
 *
 * PHP version 7.1
 *
 * @category Tests
 * @package  CanIHaveSomeCoffee\TheTVDbAPI\Tests\MultiLanguageWrapper\Route
 * @author   Willem Van Iseghem (canihavesomecoffee) <theTVDbAPI@canihavesome.coffee>
 * @license  See start of document
 * @link     https://canihavesome.coffee/projects/theTVDbAPI
 */
declare(strict_types = 1);

namespace CanIHaveSomeCoffee\TheTVDbAPI\Tests\MultiLanguageWrapper\Route;

use CanIHaveSomeCoffee\TheTVDbAPI\Model\BasicSeries;
use CanIHaveSomeCoffee\TheTVDbAPI\MultiLanguageWrapper\MultiLanguageFallbackGenerator;
use CanIHaveSomeCoffee\TheTVDbAPI\MultiLanguageWrapper\Route\SearchRouteLanguageFallback;

/**
 * Tests the SearchRouteLanguageFallback class.
 *
 * @category Tests
 * @package  CanIHaveSomeCoffee\TheTVDbAPI\Tests\MultiLanguageWrapper\Route
 * @author   Willem Van Iseghem (canihavesomecoffee) <theTVDbAPI@canihavesome.coffee>
 * @license  See start of document
 * @link     https://canihavesome.coffee/projects/theTVDbAPI
 */
class SearchRouteLanguageFallbackTest extends BaseRouteLanguageFallback
{
    public function testGetClosure() {
        $options = ['query' => ['foo' => 'bar']];
        $language = 'en';
        $this->parent->expects(static::once())->method('performAPICallWithJsonResponse')->with(
            static::equalTo('get'),
            static::equalTo('/search/series'),
            static::equalTo(array_merge(['headers' => ['Accept-Language' => $language]], $options))
        )->willReturn([
            ['id' => 123, 'title' => 'foo'],
            ['id' => 124, 'title' => 'bar']
        ]);
        $route = new SearchRouteLanguageFallback($this->parent);
        $instance = $route->getClosureForSearch($options);
        static::assertInstanceOf(\Closure::class, $instance);
        $return = $instance($language);
        static::assertTrue(is_array($return));
        static::assertCount(2, $return);
        static::assertContainsOnly(BasicSeries::class, $return);
    }

    public function testSearch()
    {
        $accepted = ['nl', 'en'];
        $result = [new BasicSeries()];
        $mock_generator = $this->createMock(MultiLanguageFallbackGenerator::class);
        $mock_generator->expects(static::once())->method('create')->with(
            static::isInstanceOf(\Closure::class), static::equalTo(BasicSeries::class), static::equalTo($accepted)
        )->willReturn($result);
        $this->parent->expects(static::once())->method('getAcceptedLanguages')->willReturn($accepted);
        $this->parent->expects(static::once())->method('getGenerator')->willReturn($mock_generator);
        $instance = new SearchRouteLanguageFallback($this->parent);
        $return = $instance->search('name', 'foo');
        static::assertTrue(is_array($return));
        static::assertCount(1, $return);
        static::assertContainsOnly(BasicSeries::class, $return);
    }

    public function testInvalidSearch() {
        $mock_generator = $this->createMock(MultiLanguageFallbackGenerator::class);
        $mock_generator->expects(static::never())->method('create');
        $this->parent->expects(static::never())->method('getAcceptedLanguages');
        $this->parent->expects(static::never())->method('getGenerator');
        $instance = new SearchRouteLanguageFallback($this->parent);
        static::expectException(\InvalidArgumentException::class);
        $instance->search('invalid', 'foo');
    }
}
