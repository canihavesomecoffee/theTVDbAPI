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
 * Represents a JSON error returned by the API.
 *
 * PHP version 7.1
 *
 * @category TheTVDbAPI
 * @package  CanIHaveSomeCoffee\TheTVDbAPI\Model
 * @author   Willem Van Iseghem (canihavesomecoffee) <theTVDbAPI@canihavesome.coffee>
 * @license  See start of document
 * @link     https://canihavesome.coffee/projects/theTVDbAPI
 */
declare(strict_types = 1);

namespace CanIHaveSomeCoffee\TheTVDbAPI\Model;

/**
 * Class JSONError
 *
 * @category TheTVDbAPI
 * @package  CanIHaveSomeCoffee\TheTVDbAPI\Model
 * @author   Willem Van Iseghem (canihavesomecoffee) <theTVDbAPI@canihavesome.coffee>
 * @license  See start of document
 * @link     https://canihavesome.coffee/projects/theTVDbAPI
 */
class JSONError
{
    /**
     * Invalid filters passed to route.
     */
    const INVALID_FILTER = 1;
    /**
     * Invalid language or translation missing.
     */
    const INVALID_LANGUAGE = 2;
    /**
     * Invalid query params passed to route.
     */
    const INVALID_QUERYPARAMS = 3;

    /**
     * The error type.
     *
     * @var integer
     */
    private $type;

    /**
     * Contains the message or the returned data.
     *
     * @var mixed
     */
    private $data;


    /**
     * JSONError constructor.
     *
     * @param int   $type The type of this error.
     * @param mixed $data The optional data of this error.
     */
    public function __construct($type = JSONError::INVALID_LANGUAGE, $data = null)
    {
        $this->type = $type;
        $this->data = $data;
    }

    /**
     * Gets the Type
     *
     * @return int
     */
    public function getType(): int
    {
        return $this->type;
    }

    /**
     * Gets the Data
     *
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }
}
