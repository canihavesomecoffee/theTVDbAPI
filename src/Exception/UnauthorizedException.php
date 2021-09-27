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
 * Class that indicates a request returned a 401 Unauthorized status code.
 *
 * PHP version 7.4
 *
 * @category TheTVDbAPI
 * @package  CanIHaveSomeCoffee\TheTVDbAPI\Exception
 * @author   Willem Van Iseghem (canihavesomecoffee) <theTVDbAPI@canihavesome.coffee>
 * @license  See start of document
 * @link     https://canihavesome.coffee/projects/theTVDbAPI
 */
declare(strict_types = 1);

namespace CanIHaveSomeCoffee\TheTVDbAPI\Exception;

use Exception;

/**
 * Class UnauthorizedException
 *
 * @category TheTVDbAPI
 * @package  CanIHaveSomeCoffee\TheTVDbAPI\Exception
 * @author   Willem Van Iseghem (canihavesomecoffee) <theTVDbAPI@canihavesome.coffee>
 * @license  See start of document
 * @link     https://canihavesome.coffee/projects/theTVDbAPI
 */
class UnauthorizedException extends Exception
{
    /**
     * Error message for an invalid token.
     */
    const TOKEN_MESSAGE = 'Unauthorized; please provide valid token.';
    /**
     * Error message for invalid user credentials.
     */
    const CREDENTIALS_MESSAGE = 'Unauthorized; please provide valid credentials.';


    /**
     * Returns a new exception for an invalid token.
     *
     * @return UnauthorizedException
     */
    public static function invalidToken(): UnauthorizedException
    {
        return new static(static::TOKEN_MESSAGE);
    }

    /**
     * Returns an exception for invalid credentials.
     *
     * @return UnauthorizedException
     */
    public static function invalidCredentials(): UnauthorizedException
    {
        return new static(static::CREDENTIALS_MESSAGE);
    }


}
