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

namespace CanIHaveSomeCoffee\TheTVDbAPI\Tests;

use CanIHaveSomeCoffee\TheTVDbAPI\DataParser;
use CanIHaveSomeCoffee\TheTVDbAPI\Model\EpisodeBaseRecord;
use CanIHaveSomeCoffee\TheTVDbAPI\Model\SeriesBaseRecord;
use PHPUnit\Framework\TestCase;

/**
 * Class DataParserTest
 *
 * @category TheTVDbAPI
 * @package  CanIHaveSomeCoffee\TheTVDbAPI\Tests
 * @author   Willem Van Iseghem (canihavesomecoffee) <theTVDbAPI@canihavesome.coffee>
 * @license  See start of document
 * @link     https://canihavesome.coffee/projects/theTVDbAPI
 */
class DataParserTest extends TestCase
{
    public function testParseBasicEpisodeData()
    {
        $json = [
            json_decode('{
        "id": 7421162,
        "seriesId": 280258,
        "name": "Thibault Christiaensen",
        "aired": "2019-10-29",
        "runtime": 45,
        "nameTranslations": [
          "eng",
          "nld"
        ],
        "overview": null,
        "overviewTranslations": [
          "nld"
        ],
        "image": "https://artworks.thetvdb.com/banners/series/280258/episodes/62076048.jpg",
        "imageType": 11,
        "isMovie": 0,
        "seasons": null,
        "number": 17,
        "seasonNumber": 13,
        "lastUpdated": "2020-02-08 21:20:50",
        "finaleType": null
      }', true)
        ];
        $return = DataParser::parseDataArray($json, EpisodeBaseRecord::class);
        static::assertContainsOnlyInstancesOf(EpisodeBaseRecord::class, $return);
    }

    public function testParseBasicSeriesData()
    {
        $episodeJSON = '{
        "id": "7421162",
        "seriesId": 280258,
        "name": "Thibault Christiaensen",
        "aired": "2019-10-29",
        "runtime": 45,
        "nameTranslations": [
          "eng",
          "nld"
        ],
        "overview": null,
        "overviewTranslations": [
          "nld"
        ],
        "image": "https://artworks.thetvdb.com/banners/series/280258/episodes/62076048.jpg",
        "imageType": 11,
        "isMovie": 0,
        "seasons": null,
        "number": 17,
        "seasonNumber": 13,
        "lastUpdated": "2020-02-08 21:20:50",
        "finaleType": null
      }';
        $json = [
            json_decode($episodeJSON, true),
            json_decode($episodeJSON, true),
            json_decode($episodeJSON, true)
        ];
        $return = DataParser::parseDataArray($json, SeriesBaseRecord::class);
        static::assertContainsOnlyInstancesOf(SeriesBaseRecord::class, $return);
    }
}
