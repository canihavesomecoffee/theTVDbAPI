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
 * Tests the LanguageFallBack class.
 *
 * PHP version 7.4
 *
 * @category Tests
 * @package  CanIHaveSomeCoffee\TheTVDbAPI\Tests\MultiLanguageWrapper
 * @author   Willem Van Iseghem (canihavesomecoffee) <theTVDbAPI@canihavesome.coffee>
 * @license  See start of document
 * @link     https://canihavesome.coffee/projects/theTVDbAPI
 */
declare(strict_types = 1);

namespace CanIHaveSomeCoffee\TheTVDbAPI\Tests\MultiLanguageWrapper;

use CanIHaveSomeCoffee\TheTVDbAPI\MultiLanguageWrapper\MultiLanguageFallbackGenerator;
use CanIHaveSomeCoffee\TheTVDbAPI\MultiLanguageWrapper\Route\EpisodesRouteLanguageFallback;
use CanIHaveSomeCoffee\TheTVDbAPI\MultiLanguageWrapper\Route\SearchRouteLanguageFallback;
use CanIHaveSomeCoffee\TheTVDbAPI\MultiLanguageWrapper\Route\SeriesRouteLanguageFallback;
use CanIHaveSomeCoffee\TheTVDbAPI\MultiLanguageWrapper\TheTVDbAPILanguageFallback;
use CanIHaveSomeCoffee\TheTVDbAPI\Route\AuthenticationRoute;
use CanIHaveSomeCoffee\TheTVDbAPI\Route\EpisodesRoute;
use CanIHaveSomeCoffee\TheTVDbAPI\Route\LanguagesRoute;
use CanIHaveSomeCoffee\TheTVDbAPI\Route\SearchRoute;
use CanIHaveSomeCoffee\TheTVDbAPI\Route\SeriesRoute;
use CanIHaveSomeCoffee\TheTVDbAPI\Route\UpdatesRoute;
use CanIHaveSomeCoffee\TheTVDbAPI\Route\UsersRoute;
use PHPUnit\Framework\TestCase;

/**
 * Tests the LanguageFallBack class.
 *
 * @category Tests
 * @package  CanIHaveSomeCoffee\TheTVDbAPI\Tests\MultiLanguageWrapper
 * @author   Willem Van Iseghem (canihavesomecoffee) <theTVDbAPI@canihavesome.coffee>
 * @license  See start of document
 * @link     https://canihavesome.coffee/projects/theTVDbAPI
 */
class TheTVDbAPILanguageFallbackTest extends TestCase
{
    public function testGetGenerator() {
        $instance = new TheTVDbAPILanguageFallback();
        static::assertInstanceOf(MultiLanguageFallbackGenerator::class, $instance->getGenerator());
    }

    public function testRouteInstanceTypes()
    {
        $instance = new TheTVDbAPILanguageFallback();

        static::assertInstanceOf(AuthenticationRoute::class, $instance->authentication());
        static::assertInstanceOf(EpisodesRoute::class, $instance->episodes());
        static::assertInstanceOf(LanguagesRoute::class, $instance->languages());
        static::assertInstanceOf(SearchRoute::class, $instance->search());
        static::assertInstanceOf(UpdatesRoute::class, $instance->updates());
        static::assertInstanceOf(UsersRoute::class, $instance->users());
        static::assertInstanceOf(SeriesRoute::class, $instance->series());

        static::assertInstanceOf(EpisodesRouteLanguageFallback::class, $instance->episodes());
        static::assertInstanceOf(SearchRouteLanguageFallback::class, $instance->search());
        static::assertInstanceOf(SeriesRouteLanguageFallback::class, $instance->series());
    }
}
