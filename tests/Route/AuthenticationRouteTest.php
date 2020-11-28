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

use CanIHaveSomeCoffee\TheTVDbAPI\Exception\UnauthorizedException;
use CanIHaveSomeCoffee\TheTVDbAPI\Route\AuthenticationRoute;

/**
 * Class AuthenticationRouteTest
 *
 * @category TheTVDbAPI
 * @package  CanIHaveSomeCoffee\TheTVDbAPI\Tests
 * @author   Willem Van Iseghem (canihavesomecoffee) <theTVDbAPI@canihavesome.coffee>
 * @license  See start of document
 * @link     https://canihavesome.coffee/projects/theTVDbAPI
 */
class AuthenticationRouteTest extends BaseRouteTest
{
    public function testAPIKeyLogin()
    {
        $expected_token = 'bar';
        $api_key = 'FOO';
        $this->parent->method('performAPICallWithJsonResponse')->willReturn(['token' => $expected_token]);
        $this->parent->expects(static::once())->method('performAPICallWithJsonResponse')->with(
            static::equalTo('post'),
            static::equalTo('/login'),
            static::equalTo(['body' => json_encode(['apikey' => $api_key]), 'http_errors' => true])
        );
        $instance = new AuthenticationRoute($this->parent);
        $token = $instance->login($api_key);
        static::assertEquals($expected_token, $token);
    }

    public function testAPIAndUserLogin()
    {
        $api_key = "FOO";
        $userPIN = "bar";
        $expected_token = 'bar';
        $this->parent->method('performAPICallWithJsonResponse')->willReturn(['token' => $expected_token]);
        $this->parent->expects(static::once())->method('performAPICallWithJsonResponse')->with(
            static::equalTo('post'),
            static::equalTo('/login'),
            static::equalTo([
                'body' => json_encode(['apikey' => $api_key, 'pin' => $userPIN]),
                'http_errors' => true
            ])
        );
        $instance = new AuthenticationRoute($this->parent);
        $token = $instance->login($api_key, $userPIN);
        static::assertEquals($expected_token, $token);
    }

    public function testAPIAndUserMissingUserKey()
    {
        $instance = new AuthenticationRoute($this->parent);
        static::expectException(\InvalidArgumentException::class);
        $instance->login('FOO');
    }

    public function testAPIKeyWrongToken()
    {
        $api_key = "FOO";
        $this->parent->method('performAPICallWithJsonResponse')->willReturn(['error' => 'Invalid token']);
        $this->parent->expects(static::once())->method('performAPICallWithJsonResponse')->with(
            static::equalTo('post'),
            static::equalTo('/login'),
            static::equalTo(['body' => json_encode(['apikey' => $api_key]), 'http_errors' => true])
        );
        $instance = new AuthenticationRoute($this->parent);
        static::expectException(UnauthorizedException::class);
        static::expectExceptionMessage(UnauthorizedException::CREDENTIALS_MESSAGE);
        $instance->login($api_key);
    }
}
