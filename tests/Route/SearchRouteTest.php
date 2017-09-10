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

use CanIHaveSomeCoffee\TheTVDbAPI\Model\BasicSeries;
use CanIHaveSomeCoffee\TheTVDbAPI\Route\SearchRoute;

/**
 * Class SearchRouteTest
 *
 * @category TheTVDbAPI
 * @package  CanIHaveSomeCoffee\TheTVDbAPI\Tests
 * @author   Willem Van Iseghem (canihavesomecoffee) <theTVDbAPI@canihavesome.coffee>
 * @license  See start of document
 * @link     https://canihavesome.coffee/projects/theTVDbAPI
 */
class SearchRouteTest extends BaseRouteTest
{
    public function testSearchInvalidSpecifier()
    {
        $instance = new SearchRoute($this->parent);
        static::expectException(\InvalidArgumentException::class);
        $instance->search('invalid', 'foo');
    }

    private function setMockData($return, $options)
    {
        $this->parent->method('performAPICallWithJsonResponse')->willReturn($return);
        $this->parent->expects(static::once())->method('performAPICallWithJsonResponse')->with(
            static::equalTo('get'),
            static::equalTo('/search/series'),
            static::equalTo($options)
        );
    }

    public function testSearchByName()
    {
        $name = 'foo';
        $return = [
            ['id' => 1, 'seriesName' => 'foo'],
            ['id' => 3, 'seriesName' => 'foo bar']
        ];
        $options = ['query' => [SearchRoute::SEARCH_NAME => $name]];
        $this->setMockData($return, $options);
        $instance = new SearchRoute($this->parent);
        $results = $instance->searchByName($name);
        static::assertContainsOnlyInstancesOf(BasicSeries::class, $results);
    }

    public function testSearchByIMDb()
    {
        $name = 'tt123';
        $return = [
            ['id' => 1, 'seriesName' => 'foo'],
            ['id' => 3, 'seriesName' => 'foo bar']
        ];
        $options = ['query' => [SearchRoute::SEARCH_IMDB => $name]];
        $this->setMockData($return, $options);
        $instance = new SearchRoute($this->parent);
        $results = $instance->searchByIMDbId($name);
        static::assertContainsOnlyInstancesOf(BasicSeries::class, $results);
    }

    public function testSearchByZap2It()
    {
        $name = 'z2it';
        $return = [
            ['id' => 1, 'seriesName' => 'foo'],
            ['id' => 3, 'seriesName' => 'foo bar']
        ];
        $options = ['query' => [SearchRoute::SEARCH_ZAP2IT => $name]];
        $this->setMockData($return, $options);
        $instance = new SearchRoute($this->parent);
        $results = $instance->searchByZap2ItId($name);
        static::assertContainsOnlyInstancesOf(BasicSeries::class, $results);
    }
}
