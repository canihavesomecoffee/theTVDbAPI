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
 * Example to show retrieving a Dutch show (which misses most English titles) using Dutch as the fallback.
 *
 * PHP version 7.4
 *
 * @category Examples
 * @author   Willem Van Iseghem (canihavesomecoffee) <theTVDbAPI@canihavesome.coffee>
 * @license  See start of document
 * @link     https://canihavesome.coffee/projects/theTVDbAPI
 */

declare(strict_types=1);

use CanIHaveSomeCoffee\TheTVDbAPI\TheTVDbAPI;

require_once __DIR__ . '/../vendor/autoload.php';

$accessKey = getenv('PROJECT_KEY');

$theTVDbAPI = new TheTVDbAPI();

// Login and set the token.
$token = $theTVDbAPI->authentication()->login($accessKey);
$theTVDbAPI->setToken($token);

// Get updates since the last 15 minutes.
$now = new DateTime();
$now->sub(new DateInterval("PT15M"));
$data = $theTVDbAPI->updates()->query($now);

/*
    This will yield something like:
    array(28) {
        [0]=>
        object(CanIHaveSomeCoffee\TheTVDbAPI\Model\EntityUpdate)#52 (4) {
    ["entityType"]=>
    string(6) "series"
    ["method"]=>
    string(6) "create"
    ["recordId"]=>
    int(366751)
    ["timeStamp"]=>
    int(1631921873)
          }
          [1]=>
          object(CanIHaveSomeCoffee\TheTVDbAPI\Model\EntityUpdate)#86 (4) {
    ["entityType"]=>
    string(8) "episodes"
    ["method"]=>
    string(6) "create"
    ["recordId"]=>
    int(8684096)
    ["timeStamp"]=>
    int(1631921874)
          }
          [2]=>
          object(CanIHaveSomeCoffee\TheTVDbAPI\Model\EntityUpdate)#79 (4) {
    ["entityType"]=>
    string(18) "translatedepisodes"
    ["method"]=>
    string(6) "create"
    ["recordId"]=>
    int(6809798)
    ["timeStamp"]=>
    int(1631921875)
         }
        ...
    }
*/
