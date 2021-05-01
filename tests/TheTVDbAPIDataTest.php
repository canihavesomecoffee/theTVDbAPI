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

namespace CanIHaveSomeCoffee\TheTVDbAPI\Tests;

use CanIHaveSomeCoffee\TheTVDbAPI\TheTVDbAPI;
use PHPUnit\Framework\TestCase;

/**
 * Class TheTVDbAPIDataTest tests with real data from the live API.
 *
 * @category TheTVDbAPI
 * @package  CanIHaveSomeCoffee\TheTVDbAPI\Tests
 * @author   Willem Van Iseghem (canihavesomecoffee) <theTVDbAPI@canihavesome.coffee>
 * @license  See start of document
 * @link     https://canihavesome.coffee/projects/theTVDbAPI
 */
class TheTVDbAPIDataTest extends TestCase
{
    /** @type TheTVDbAPI */
    protected $theTVDbAPI;

    /**
     * {@inheritdoc}
     */
    public function setUp(): void
    {
        // Set up an authenticated client
        $this->theTVDbAPI = new TheTVDbAPI();

        /*$token = $this->theTVDbAPI->authentication()->login(
            getenv("API_KEY"), getenv("API_USER"), getenv("API_USER_KEY")
        );

        static::assertInternalType('string', $token);

        $this->theTVDbAPI->setToken($token);*/
    }

    public function testDummy()
    {
        // TODO: write tests
        static::assertTrue(true);
    }
}
