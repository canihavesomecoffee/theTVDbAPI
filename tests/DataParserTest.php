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
use CanIHaveSomeCoffee\TheTVDbAPI\Model\BasicEpisode;
use CanIHaveSomeCoffee\TheTVDbAPI\Model\BasicSeries;
use CanIHaveSomeCoffee\TheTVDbAPI\Model\Image;
use CanIHaveSomeCoffee\TheTVDbAPI\Model\RatingsInfo;
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
            json_decode('{"absoluteNumber": null, "airedEpisodeNumber": 0, "airedSeason": 0, "airedSeasonID": 0, "dvdEpisodeNumber": null, "dvdSeason": null, "episodeName": "string",  "firstAired": "2018-04-10", "id": 0, "language": { "episodeName": "en", "overview": "en" }, "lastUpdated": 1523605586, "overview": "string"}', true)
        ];
        $return = DataParser::parseDataArray($json, BasicEpisode::class);
        static::assertContainsOnlyInstancesOf(BasicEpisode::class, $return);
    }

    public function testParseBasicSeriesData()
    {
        $json = [
            json_decode('{"added": "string", "airsDayOfWeek": "string", "airsTime": "string", "aliases": [ "string" ], "banner": "string", "firstAired": "string", "genre": [ "string" ], "id": 0, "imdbId": "string", "lastUpdated": 0, "network": "string", "networkId": "string", "overview": "string", "rating": "string", "runtime": "string", "seriesId": 0, "seriesName": "string", "siteRating": 0, "siteRatingCount": 0, "status": "string", "zap2itId": "string"}', true),
            json_decode('{"added": "string", "airsDayOfWeek": "string", "airsTime": "string", "aliases": [ "string" ], "banner": "string", "firstAired": "string", "genre": [ "string" ], "id": 0, "imdbId": "string", "lastUpdated": 0, "network": "string", "networkId": "string", "overview": "string", "rating": "string", "runtime": "string", "seriesId": 0, "seriesName": "string", "siteRating": 0, "siteRatingCount": 0, "status": "string", "zap2itId": "string"}', true),
            json_decode('{"added": "string", "airsDayOfWeek": "string", "airsTime": "string", "aliases": [ "string" ], "banner": "string", "firstAired": "string", "genre": [], "id": 0, "imdbId": "string", "lastUpdated": 0, "network": "string", "networkId": "string", "overview": null, "rating": "string", "runtime": "string", "seriesId": 0, "seriesName": null, "siteRating": 0, "siteRatingCount": 0, "status": "string", "zap2itId": "string"}', true)
        ];
        $return = DataParser::parseDataArray($json, BasicSeries::class);
        static::assertContainsOnlyInstancesOf(BasicSeries::class, $return);
    }

    public function testParseImage()
    {
        $json   = [
            json_decode('{ "id": 845571, "keyType": "series", "subKey": "graphical", "fileName": "graphical/236061-g.jpg", "resolution": "", "ratingsInfo": { "average": 8, "count": 5 }, "thumbnail": "_cache/graphical/236061-g.jpg"}', true),
            json_decode('{ "id": 845571, "keyType": "series", "subKey": "graphical", "fileName": "graphical/236061-g.jpg", "resolution": "", "ratingsInfo": { "average": 8.5, "count": 5 }, "thumbnail": "_cache/graphical/236061-g.jpg"}', true)
        ];
        /** @var Image $return */
        $return = DataParser::parseDataArray($json, Image::class);
        static::assertContainsOnlyInstancesOf(Image::class, $return);
        static::assertInstanceOf(RatingsInfo::class, $return[0]->ratingsInfo);
    }
}
