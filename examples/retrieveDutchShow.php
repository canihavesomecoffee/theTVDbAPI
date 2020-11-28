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

require_once __DIR__.'/../vendor/autoload.php';

$accessKey = getenv('PROJECT_KEY');

$theTVDbAPI = new TheTVDbAPI();

// Login and set the token.
$token = $theTVDbAPI->authentication()->login($accessKey);
$theTVDbAPI->setToken($token);

// Retrieve an episode from a Dutch show.
$episode = $theTVDbAPI->episodes()->simple(6347388);
var_dump($episode);

/*
    This will yield something like:
    object(CanIHaveSomeCoffee\TheTVDbAPI\Model\EpisodeExtendedRecord)#46 (14) {
      ["airsAfterSeason"]=>
      NULL
      ["airsBeforeSeason"]=>
      NULL
      ["airsBeforeEpisode"]=>
      NULL
      ["awards"]=>
      uninitialized(array)
      ["characters"]=>
      uninitialized(array)
      ["contentRatings"]=>
      uninitialized(array)
      ["network"]=>
      uninitialized(CanIHaveSomeCoffee\TheTVDbAPI\Model\NetworkBaseRecord)
      ["productionCode"]=>
      uninitialized(string)
      ["tagOptions"]=>
      uninitialized(array)
      ["trailers"]=>
      uninitialized(array)
      ["aired"]=>
      string(10) "2017-10-05"
      ["id"]=>
      int(6347388)
      ["image"]=>
      NULL
      ["imageType"]=>
      NULL
      ["isMovie"]=>
      int(0)
      ["name"]=>
      string(13) "Imke Courtois"
      ["nameTranslations"]=>
      array(1) {
        [0]=>
        string(3) "nld"
      }
      ["overviewTranslations"]=>
      array(0) {
      }
      ["runtime"]=>
      int(45)
      ["seasons"]=>
      array(1) {
        [0]=>
        array(10) {
          ["id"]=>
          int(728669)
          ["seriesId"]=>
          int(280258)
          ["type"]=>
          array(3) {
            ["id"]=>
            int(1)
            ["name"]=>
            string(11) "Aired Order"
            ["type"]=>
            string(8) "official"
          }
          ["name"]=>
          NULL
          ["number"]=>
          int(9)
          ["nameTranslations"]=>
          NULL
          ["overviewTranslations"]=>
          NULL
          ["image"]=>
          NULL
          ["imageType"]=>
          NULL
          ["network"]=>
          array(5) {
            ["id"]=>
            int(51)
            ["name"]=>
            string(6) "Canvas"
            ["slug"]=>
            string(12) "canvasketnet"
            ["abbreviation"]=>
            string(6) "Canvas"
            ["country"]=>
            string(3) "bel"
          }
        }
      }
      ["seriesId"]=>
      int(280258)
    }
*/
