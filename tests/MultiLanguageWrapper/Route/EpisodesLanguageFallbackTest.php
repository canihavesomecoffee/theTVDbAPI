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

namespace CanIHaveSomeCoffee\TheTVDbAPI\Tests\MultiLanguageWrapper\Route;

use CanIHaveSomeCoffee\TheTVDbAPI\Model\Episode;
use CanIHaveSomeCoffee\TheTVDbAPI\MultiLanguageWrapper\MultiLanguageFallbackGenerator;
use CanIHaveSomeCoffee\TheTVDbAPI\MultiLanguageWrapper\Route\EpisodesRouteLanguageFallback;

/**
 * Class EpisodesLanguageFallbackTest
 *
 * @category TheTVDbAPI
 * @package  CanIHaveSomeCoffee\TheTVDbAPI\Tests
 * @author   Willem Van Iseghem (canihavesomecoffee) <theTVDbAPI@canihavesome.coffee>
 * @license  See start of document
 * @link     https://canihavesome.coffee/projects/theTVDbAPI
 */
class EpisodesLanguageFallbackTest extends BaseRouteLanguageFallback
{
    public function testGetClosure() {
        $accepted = ['nl', 'en'];
        $episode_id = 1337;
        $overview = 'foo bar baz';
        $this->parent->expects(static::exactly(2))->method('performAPICallWithJsonResponse')->withConsecutive(
            [
                static::equalTo('get'),
                static::equalTo('/episodes/'.$episode_id),
                static::equalTo(['headers' => ['Accept-Language' => $accepted[0]]])
            ],
            [
                static::equalTo('get'),
                static::equalTo('/episodes/'.$episode_id),
                static::equalTo(['headers' => ['Accept-Language' => $accepted[1]]])
            ]
        )->willReturn(
            ['id' => $episode_id, 'overview' => null],
            ['id' => $episode_id, 'overview' => $overview]
        );
        $route = new EpisodesRouteLanguageFallback($this->parent);
        $instance = $route->getClosureById($episode_id);
        static::assertInstanceOf(\Closure::class, $instance);
        $first = $instance($accepted[0]);
        static::assertInstanceOf(Episode::class, $first);
        static::assertEquals($episode_id, $first->id);
        static::assertEquals(null, $first->overview);
        $second = $instance($accepted[1]);
        static::assertInstanceOf(Episode::class, $second);
        static::assertEquals($episode_id, $second->id);
        static::assertEquals($overview, $second->overview);

    }

    public function testGetEpisodeWithGivenId()
    {
        $accepted = ['nl', 'en'];
        $episode_id = 1337;
        $overview = 'foo bar baz';
        $result = new Episode();
        $result->id = $episode_id;
        $result->overview = $overview;
        $mock_generator = $this->createMock(MultiLanguageFallbackGenerator::class);
        $mock_generator->expects(static::once())->method('create')->with(
            static::isInstanceOf(\Closure::class), static::equalTo(Episode::class), static::equalTo($accepted)
        )->willReturn($result);
        $this->parent->expects(static::once())->method('getAcceptedLanguages')->willReturn($accepted);
        $this->parent->expects(static::once())->method('getGenerator')->willReturn($mock_generator);
        $instance = new EpisodesRouteLanguageFallback($this->parent);
        $episode = $instance->byId($episode_id);
        static::assertInstanceOf(Episode::class, $episode);
        static::assertEquals($episode_id, $episode->id);
        static::assertEquals($overview, $episode->overview);
    }
}
