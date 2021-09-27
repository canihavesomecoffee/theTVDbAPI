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
use GuzzleHttp\Psr7\Query;
use PHPUnit\Framework\TestCase;

/**
 * Class ExceptionTest
 *
 * @category TheTVDbAPI
 * @package  CanIHaveSomeCoffee\TheTVDbAPI\Tests
 * @author   Willem Van Iseghem (canihavesomecoffee) <theTVDbAPI@canihavesome.coffee>
 * @license  See start of document
 * @link     https://canihavesome.coffee/projects/theTVDbAPI
 */
class ExceptionTest extends TestCase
{


    /**
     * Test that for a correct error message can be constructed.
     *
     * @return void
     * @throws UnauthorizedException
     */
    public function testCreateErrorMessage(): void
    {
        $base       = "Error.";
        $path       = "foo/bar/baz";
        $parameters = ['foo' => 'bar', 'baz'];
        static::assertEquals($base, ResourceNotFoundException::createErrorMessage($base));
        $expectedError = $base.sprintf(ResourceNotFoundException::PATH_MESSAGE, $path, '');
        static::assertEquals($expectedError, ResourceNotFoundException::createErrorMessage($base, $path));
        $expectedError = $base.sprintf(
            ResourceNotFoundException::PATH_MESSAGE,
            $path,
            Query::build($parameters)
        );
        static::assertEquals($expectedError, ResourceNotFoundException::createErrorMessage($base, $path, $parameters));
    }

    /**
     * Test that a credential exception has the correct type and error message.
     *
     * @return void
     * @throws UnauthorizedException
     */
    public function testCredentialsException(): void
    {
        static::expectException(UnauthorizedException::class);
        static::expectExceptionMessage(UnauthorizedException::CREDENTIALS_MESSAGE);
        throw UnauthorizedException::invalidCredentials();
    }

    /**
     * Test that a token exception has the correct type and error message.
     *
     * @return void
     * @throws UnauthorizedException
     */
    public function testTokenException(): void
    {
        static::expectException(UnauthorizedException::class);
        static::expectExceptionMessage(UnauthorizedException::TOKEN_MESSAGE);
        throw UnauthorizedException::invalidToken();
    }

    /**
     * Test that a not found exception has the correct type and error message.
     *
     * @return void
     * @throws UnauthorizedException
     */
    public function testNotFoundException(): void
    {
        static::expectException(ResourceNotFoundException::class);
        static::expectExceptionMessage(
            ResourceNotFoundException::createErrorMessage(ResourceNotFoundException::NOT_FOUND_MESSAGE)
        );
        throw ResourceNotFoundException::notFound();
    }

    /**
     * Test that a not found exception (including a query) has the correct type and error message.
     *
     * @return void
     * @throws UnauthorizedException
     */
    public function testNotFoundExceptionWithQuery(): void
    {
        $path    = "some/long/path";
        $options = ['query' => ['foobar']];
        static::expectException(ResourceNotFoundException::class);
        static::expectExceptionMessage(
            ResourceNotFoundException::createErrorMessage(
                ResourceNotFoundException::NOT_FOUND_MESSAGE,
                $path,
                $options['query']
            )
        );
        throw ResourceNotFoundException::notFound($path, $options);
    }

    /**
     * Test that an exception for missing translations has the correct type and error message.
     *
     * @return void
     * @throws UnauthorizedException
     */
    public function testNoTranslationException(): void
    {
        static::expectException(ResourceNotFoundException::class);
        static::expectExceptionMessage(
            ResourceNotFoundException::createErrorMessage(ResourceNotFoundException::NO_TRANSLATION_MESSAGE)
        );
        throw ResourceNotFoundException::noTranslationAvailable();
    }

    /**
     * Test that an exception (including a query) for missing translations has the correct type and error message.
     *
     * @return void
     * @throws UnauthorizedException
     */
    public function testNoTranslationExceptionWithQuery(): void
    {
        $path    = "some/long/path";
        $options = ['query' => ['foobar']];
        static::expectException(ResourceNotFoundException::class);
        static::expectExceptionMessage(
            ResourceNotFoundException::createErrorMessage(
                ResourceNotFoundException::NO_TRANSLATION_MESSAGE,
                $path,
                $options['query']
            )
        );
        throw ResourceNotFoundException::noTranslationAvailable($path, $options);
    }

    /**
     * Test that a decoding exception has the correct type and error message.
     *
     * @return void
     * @throws UnauthorizedException
     */
    public function testDecodeException(): void
    {
        static::expectException(ParseException::class);
        static::expectExceptionMessage(ParseException::DECODE_MESSAGE);
        throw ParseException::decode();
    }

    /**
     * Test that a missing header exception has the correct type and error message.
     *
     * @return void
     * @throws UnauthorizedException
     */
    public function testMissingHeaderException(): void
    {
        $header = 'ABC';
        static::expectException(ParseException::class);
        static::expectExceptionMessage(sprintf(ParseException::HEADER_MESSAGE, $header));
        throw ParseException::missingHeader($header);
    }

    /**
     * Test that an exception for an invalid timestamp has the correct type and error message.
     *
     * @return void
     * @throws UnauthorizedException
     */
    public function testFailedTimestampException(): void
    {
        $timestamp = '2017-05-05 13...';
        static::expectException(ParseException::class);
        static::expectExceptionMessage(sprintf(ParseException::MODIFIED_MESSAGE, $timestamp));
        throw ParseException::lastModified($timestamp);
    }
}
