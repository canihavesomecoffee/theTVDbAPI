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

// Get the first page of series
$data = $theTVDbAPI->series()->list();
var_dump($data);
var_dump($theTVDbAPI->getLinks());

/*
    This results in something like

    Links:
    object(CanIHaveSomeCoffee\TheTVDbAPI\Model\Links)#53 (3) {
      ["prev"]=>
      NULL
      ["self"]=>
      string(41) "https://api4.thetvdb.com/v4/series?page=0"
      ["next"]=>
      string(41) "https://api4.thetvdb.com/v4/series?page=1"
    }

    Data array:
    {
    ...
      [499]=>
      object(CanIHaveSomeCoffee\TheTVDbAPI\Model\SeriesBaseRecord)#1245 (15) {
    ["abbreviation"]=>
    uninitialized(string)
    ["aliases"]=>
    array(0) {
    }
    ["country"]=>
    uninitialized(string)
    ["defaultSeasonType"]=>
    int(1)
    ["firstAired"]=>
    string(10) "1995-09-20"
    ["id"]=>
    int(70903)
    ["image"]=>
    NULL
    ["isOrderRandomized"]=>
    bool(false)
    ["lastAired"]=>
    string(10) "1995-09-20"
    ["name"]=>
    string(23) "The George & Alana Show"
    ["nameTranslations"]=>
    array(1) {
      [0]=>
      string(3) "eng"
    }
    ["nextAired"]=>
    string(0) ""
    ["originalCountry"]=>
    NULL
    ["originalLanguage"]=>
    string(3) "eng"
    ["score"]=>
    float(0)
    ["slug"]=>
    string(25) "the-george-and-alana-show"
    ["status"]=>
    object(CanIHaveSomeCoffee\TheTVDbAPI\Model\Status)#1248 (4) {
      ["id"]=>
      NULL
      ["keepUpdated"]=>
      bool(false)
      ["name"]=>
      NULL
      ["recordType"]=>
      string(0) ""
    }
      }
    }
*/
