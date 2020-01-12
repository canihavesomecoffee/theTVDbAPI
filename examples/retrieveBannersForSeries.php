<?php
/**
 * Copyright (c) 2020, Willem Van Iseghem (canihavesomecoffee) <theTVDbAPI@canihavesome.coffee>
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
 * PHP version 7.1
 *
 * @category Examples
 * @author   Willem Van Iseghem (canihavesomecoffee) <theTVDbAPI@canihavesome.coffee>
 * @license  See start of document
 * @link     https://canihavesome.coffee/projects/theTVDbAPI
 */

declare(strict_types=1);

use CanIHaveSomeCoffee\TheTVDbAPI\MultiLanguageWrapper\TheTVDbAPILanguageFallback;

require_once __DIR__.'/../vendor/autoload.php';

$accessKey = 'YOURKEYHERE';

$theTVDbAPI = new TheTVDbAPILanguageFallback();
$theTVDbAPI->setAcceptedLanguages(['nl', 'en']);

// Login and set the token.
$token = $theTVDbAPI->authentication()->login($accessKey);
$theTVDbAPI->setToken($token);

// Retrieve artwork statistics from a Dutch show.
$artworkStatistics = $theTVDbAPI->series()->getImages(280258);
var_dump($artworkStatistics);

/*
    This will yield something like:
    class CanIHaveSomeCoffee\TheTVDbAPI\Model\ImageStatistics#41 (5) {
      public $fanart =>
      int(1)
      public $poster =>
      int(3)
      public $season =>
      NULL
      public $seasonwide =>
      NULL
      public $series =>
      NULL
    }
*/

// Retrieve banners from a Dutch show.
$artwork = $theTVDbAPI->series()->getImagesWithQuery(280258, ["keyType" => "poster"]);
var_dump($artwork);

/*
    This will yield something similar to:
    array(3) {
      [0] =>
      class CanIHaveSomeCoffee\TheTVDbAPI\Model\Image#73 (8) {
        public $fileName =>
        string(20) "posters/280258-1.jpg"
        public $id =>
        int(1191168)
        public $keyType =>
        string(6) "poster"
        public $languageId =>
        int(0)
        public $ratingsInfo =>
        class CanIHaveSomeCoffee\TheTVDbAPI\Model\RatingsInfo#120 (2) {
          public $average =>
          int(0)
          public $count =>
          int(0)
        }
        public $resolution =>
        string(8) "680x1000"
        public $subKey =>
        string(9) "graphical"
        public $thumbnail =>
        string(22) "posters/280258-1_t.jpg"
      }
      [1] =>
*/
