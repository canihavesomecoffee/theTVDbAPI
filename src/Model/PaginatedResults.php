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
 * Model to represent a paginated result.
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
 * Class PaginatedResults
 *
 * @category TheTVDbAPI
 * @package  CanIHaveSomeCoffee\TheTVDbAPI\Model
 * @author   Willem Van Iseghem (canihavesomecoffee) <theTVDbAPI@canihavesome.coffee>
 * @license  See start of document
 * @link     https://canihavesome.coffee/projects/theTVDbAPI
 */
class PaginatedResults
{
    /**
     * The results of the query.
     *
     * @var array
     */
    private $data;
    /**
     * An array holding the pagination results.
     *
     * @var array
     */
    private $links;


    /**
     * PaginatedResults constructor.
     *
     * @param array $data  The query results.
     * @param array $links The pagination results.
     */
    public function __construct(array $data, array $links)
    {
        $this->data  = $data;
        $this->links = $links;
    }

    /**
     * Gets the data from the query.
     *
     * @return array
     */
    public function getData(): array
    {
        return $this->data;
    }

    /**
     * Returns the first page, or -1 if not available.
     *
     * @return int
     */
    public function getFirstPage(): int
    {
        return $this->getLinkElement('first');
    }

    /**
     * Returns the last page, or -1 if not available.
     *
     * @return int
     */
    public function getLastPage(): int
    {
        return $this->getLinkElement('last');
    }

    /**
     * Returns the next page, or -1 if not available.
     * If the next page is 0, then it means you're on the last page.
     *
     * @return int
     */
    public function getNextPage(): int
    {
        return $this->getLinkElement('next');
    }

    /**
     * Returns the previous page, or -1 if not available.
     *
     * @return int
     */
    public function getPreviousPage(): int
    {
        return $this->getLinkElement('previous');
    }

    /**
     * Fetches a link element from the array.
     *
     * @param string $key The element to retrieve.
     *
     * @return int The element if found, or -1 if not.
     */
    private function getLinkElement(string $key): int
    {
        return (array_key_exists($key, $this->links) ? intval($this->links[$key], 10) : -1);
    }
}
