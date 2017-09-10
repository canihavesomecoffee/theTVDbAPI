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
 * Route that exposes the update methods of TheTVDb API.
 *
 * PHP version 7.1
 *
 * @category TheTVDbAPI
 * @package  CanIHaveSomeCoffee\TheTVDbAPI\Route
 * @author   Willem Van Iseghem (canihavesomecoffee) <theTVDbAPI@canihavesome.coffee>
 * @license  See start of document
 * @link     https://canihavesome.coffee/projects/theTVDbAPI
 */
declare(strict_types = 1);

namespace CanIHaveSomeCoffee\TheTVDbAPI\Route;

use CanIHaveSomeCoffee\TheTVDbAPI\DataParser;
use CanIHaveSomeCoffee\TheTVDbAPI\Model\UpdateInfo;
use DateTime;

/**
 * Class UpdatesRoute
 *
 * @category TheTVDbAPI
 * @package  CanIHaveSomeCoffee\TheTVDbAPI\Route
 * @author   Willem Van Iseghem (canihavesomecoffee) <theTVDbAPI@canihavesome.coffee>
 * @license  See start of document
 * @link     https://canihavesome.coffee/projects/theTVDbAPI
 */
class UpdatesRoute extends AbstractRoute
{


    /**
     * Fetches the series that were updated between the given timestamps. If the toTime variable is left null, the API
     * will take the current timestamp for this.
     *
     * @param DateTime      $fromTime Fetch series that were updated after this timestamp.
     * @param DateTime|null $toTime   Fetch series that were updated before this timestamp.
     *
     * @return array An array with UpdateInfo instances.
     */
    public function query(DateTime $fromTime, DateTime $toTime = null): array
    {
        $options = ['query' => ['fromTime' => $fromTime->getTimestamp()]];
        if ($toTime !== null) {
            $options['query']['toTime'] = $toTime->getTimestamp();
        }

        $json = $this->parent->performAPICallWithJsonResponse('get', '/updated/query', $options);
        return DataParser::parseDataArray($json, UpdateInfo::class);
    }
}
