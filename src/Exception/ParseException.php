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
 * Exception for when an error happens during parsing.
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
 * Class ParseException
 *
 * @category TheTVDbAPI
 * @package  CanIHaveSomeCoffee\TheTVDbAPI\Exception
 * @author   Willem Van Iseghem (canihavesomecoffee) <theTVDbAPI@canihavesome.coffee>
 * @license  See start of document
 * @link     https://canihavesome.coffee/projects/theTVDbAPI
 */
class ParseException extends Exception
{
    /**
     * The error message when the JSON could not be decoded.
     */
    const DECODE_MESSAGE = 'Could not decode JSON data';
    /**
     * The error message for when a header is missing.
     */
    const HEADER_MESSAGE = 'Could not find %s in the provided headers';
    /**
     * The error message for a failed parse of a timestamp.
     */
    const MODIFIED_MESSAGE = 'Could not convert %s into a DateTime object';


    /**
     * Returns an exception for not being able to parse the json.
     *
     * @return ParseException
     */
    public static function decode(): ParseException
    {
        return new static(static::DECODE_MESSAGE);
    }

    /**
     * Returns an exception for a missing given header.
     *
     * @param string $headerName The name of the missing header.
     *
     * @return ParseException
     */
    public static function missingHeader(string $headerName): ParseException
    {
        return new static(sprintf(static::HEADER_MESSAGE, $headerName));
    }

    /**
     * Returns an exception for a failed conversion to DateTime.
     *
     * @param string $suppliedTimestamp The timestamp that couldn't be converted.
     *
     * @return ParseException
     */
    public static function lastModified(string $suppliedTimestamp): ParseException
    {
        return new static(sprintf(static::MODIFIED_MESSAGE, $suppliedTimestamp));
    }


}
