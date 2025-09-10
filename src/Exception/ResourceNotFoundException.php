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
 * Exception for when a request cannot be fulfilled (not found).
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
use GuzzleHttp\Psr7\Query;

/**
 * Class ResourceNotFoundException
 *
 * @category TheTVDbAPI
 * @package  CanIHaveSomeCoffee\TheTVDbAPI\Exception
 * @author   Willem Van Iseghem (canihavesomecoffee) <theTVDbAPI@canihavesome.coffee>
 * @license  See start of document
 * @link     https://canihavesome.coffee/projects/theTVDbAPI
 */
class ResourceNotFoundException extends Exception
{
    /**
     * The base error message for a not found request.
     */
    const NOT_FOUND_MESSAGE = 'Could not find the requested resource!';
    /**
     * The base error message for when no translations are available.
     */
    const NO_TRANSLATION_MESSAGE = 'There is no translation available for the requested language!';
    /**
     * The string for displaying the path.
     */
    const PATH_MESSAGE = ' Requested path: %s [parameters: %s]';


    /**
     * Creates an error message for a not found exception.
     *
     * @param string      $baseMessage The base error message
     * @param string|null $path        The requested path
     * @param array       $parameters  The query parameters (if defined)
     *
     * @return string
     */
    public static function createErrorMessage(string $baseMessage, ?string $path = null, array $parameters = []): string
    {
        $errorMessage = $baseMessage;
        if ($path !== null) {
            $errorMessage .= sprintf(
                static::PATH_MESSAGE,
                $path,
                Query::build($parameters)
            );
        }
        return $errorMessage;
    }

    /**
     * Returns a new instance for the resource not found exception.
     *
     * @param string|null $path    The requested path
     * @param array       $options The options passed to the request
     *
     * @return ResourceNotFoundException
     */
    public static function notFound(?string $path = null, array $options = []): ResourceNotFoundException
    {
        $query = [];
        if (array_key_exists('query', $options)) {
            $query = $options['query'];
        }
        return new static(static::createErrorMessage(static::NOT_FOUND_MESSAGE, $path, $query));
    }

    /**
     * Returns a new instance for the resource not found exception for missing translations
     *
     * @param string|null $path    The requested path
     * @param array       $options The options passed to the request
     *
     * @return ResourceNotFoundException
     */
    public static function noTranslationAvailable(?string $path = null, array $options = []): ResourceNotFoundException
    {
        $query = [];
        if (array_key_exists('query', $options)) {
            $query = $options['query'];
        }
        return new static(static::createErrorMessage(static::NO_TRANSLATION_MESSAGE, $path, $query));
    }


}
