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

namespace CanIHaveSomeCoffee\TheTVDbAPI\Tests\Model;

use CanIHaveSomeCoffee\TheTVDbAPI\Model\PaginatedResults;
use PHPUnit\Framework\TestCase;

/**
 * Class PaginatedResultsTest
 *
 * @category TheTVDbAPI
 * @package  CanIHaveSomeCoffee\TheTVDbAPI\Tests
 * @author   Willem Van Iseghem (canihavesomecoffee) <theTVDbAPI@canihavesome.coffee>
 * @license  See start of document
 * @link     https://canihavesome.coffee/projects/theTVDbAPI
 */
class PaginatedResultsTest extends TestCase
{
    public function testRetrieveData()
    {
        $data  = ['foo' => 'bar', 'baz' => 'foo'];
        $links = ['previous' => 0, 'next' => 2, 'first' => 0, 'last' => 1337];
        $instance = new PaginatedResults($data, $links);
        static::assertEquals($data, $instance->getData());
    }

    public function testRetrievePagination()
    {
        $data  = ['foo' => 'bar', 'baz' => 'foo'];
        $links = ['previous' => 1, 'next' => 3, 'first' => 0, 'last' => 1337];
        $instance = new PaginatedResults($data, $links);
        static::assertEquals($links['previous'], $instance->getPreviousPage());
        static::assertEquals($links['next'], $instance->getNextPage());
        static::assertEquals($links['first'], $instance->getFirstPage());
        static::assertEquals($links['last'], $instance->getLastPage());
    }

    public function testRetrieveMissingPagination()
    {
        $data  = ['foo' => 'bar', 'baz' => 'foo'];
        $links = [];
        $instance = new PaginatedResults($data, $links);
        static::assertEquals(-1, $instance->getPreviousPage());
        static::assertEquals(-1, $instance->getNextPage());
        static::assertEquals(-1, $instance->getFirstPage());
        static::assertEquals(-1, $instance->getLastPage());
    }
}
