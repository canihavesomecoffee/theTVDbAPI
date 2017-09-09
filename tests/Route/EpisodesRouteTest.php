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

use CanIHaveSomeCoffee\TheTVDbAPI\Model\Episode;
use CanIHaveSomeCoffee\TheTVDbAPI\Route\EpisodesRoute;

/**
 * Class EpisodesRouteTest
 *
 * @category TheTVDbAPI
 * @package  CanIHaveSomeCoffee\TheTVDbAPI\Tests
 * @author   Willem Van Iseghem (canihavesomecoffee) <theTVDbAPI@canihavesome.coffee>
 * @license  See start of document
 * @link     https://canihavesome.coffee/projects/theTVDbAPI
 */
class EpisodesRouteTest extends BaseRouteTest
{
    public function testGetEpisodeWithGivenId()
    {
        $episode_id = 1337;
        $overview = 'foo bar baz';
        $this->parent->method('performAPICallWithJsonResponse')->willReturn(['id' => $episode_id, 'overview' => $overview]);
        $this->parent->expects(static::once())->method('performAPICallWithJsonResponse')->with(
            static::equalTo('getUserData'),
            static::equalTo('/episodes/'.$episode_id)
        );
        $instance = new EpisodesRoute($this->parent);
        $episode = $instance->byId($episode_id);
        static::assertInstanceOf(Episode::class, $episode);
        static::assertEquals($episode_id, $episode->id);
        static::assertEquals($overview, $episode->overview);
    }
}
