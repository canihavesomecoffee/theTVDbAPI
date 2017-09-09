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

use CanIHaveSomeCoffee\TheTVDbAPI\Exception\UnauthorizedException;
use CanIHaveSomeCoffee\TheTVDbAPI\Exception\ResourceNotFoundException;
use CanIHaveSomeCoffee\TheTVDbAPI\Exception\ParseException;
use CanIHaveSomeCoffee\TheTVDbAPI\Exception\ConflictException;


/**
 * Class ExceptionTest
 *
 * @category TheTVDbAPI
 * @package  CanIHaveSomeCoffee\TheTVDbAPI\Tests
 * @author   Willem Van Iseghem (canihavesomecoffee) <theTVDbAPI@canihavesome.coffee>
 * @license  See start of document
 * @link     https://canihavesome.coffee/projects/theTVDbAPI
 */
class ExceptionTest extends BaseUnitTest
{
    public function testCredentialsException()
    {
        static::expectException(UnauthorizedException::class);
        static::expectExceptionMessage(UnauthorizedException::CREDENTIALS_MESSAGE);
        throw UnauthorizedException::invalidCredentials();
    }

    public function testTokenException()
    {
        static::expectException(UnauthorizedException::class);
        static::expectExceptionMessage(UnauthorizedException::TOKEN_MESSAGE);
        throw UnauthorizedException::invalidToken();
    }

    public function testCreateErrorMessage()
    {
        $base = "Error.";
        $path = "foo/bar/baz";
        $parameters = ['foo' => 'bar', 'baz'];
        static::assertEquals($base, ResourceNotFoundException::createErrorMessage($base));
        $expected_error = $base . sprintf(ResourceNotFoundException::PATH_MESSAGE, $path, '');
        static::assertEquals($expected_error, ResourceNotFoundException::createErrorMessage($base, $path));
        $expected_error = $base . sprintf(ResourceNotFoundException::PATH_MESSAGE, $path,
                \GuzzleHttp\Psr7\build_query($parameters));
        static::assertEquals($expected_error, ResourceNotFoundException::createErrorMessage($base, $path, $parameters));
    }

    public function testNotFoundException()
    {
        static::expectException(ResourceNotFoundException::class);
        static::expectExceptionMessage(
            ResourceNotFoundException::createErrorMessage(ResourceNotFoundException::NOT_FOUND_MESSAGE));
        throw ResourceNotFoundException::notFound();
    }

    public function testNoTranslationException()
    {
        static::expectException(ResourceNotFoundException::class);
        static::expectExceptionMessage(
            ResourceNotFoundException::createErrorMessage(ResourceNotFoundException::NO_TRANSLATION_MESSAGE));
        throw ResourceNotFoundException::noTranslationAvailable();
    }

    public function testDecodeException()
    {
        static::expectException(ParseException::class);
        static::expectExceptionMessage(ParseException::DECODE_MESSAGE);
        throw ParseException::decode();
    }

    public function testMissingHeaderException()
    {
        $header = 'ABC';
        static::expectException(ParseException::class);
        static::expectExceptionMessage(sprintf(ParseException::HEADER_MESSAGE, $header));
        throw ParseException::missingHeader($header);
    }

    public function testFailedTimestampException()
    {
        $timestamp = '2017-05-05 13...';
        static::expectException(ParseException::class);
        static::expectExceptionMessage(sprintf(ParseException::MODIFIED_MESSAGE, $timestamp));
        throw ParseException::lastModified($timestamp);
    }

    public function testConflictException()
    {
        static::expectException(ConflictException::class);
        static::expectExceptionMessage(ConflictException::CONFLICT_MESSAGE);
        throw ConflictException::conflict();
    }
}
