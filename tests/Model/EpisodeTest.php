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

use CanIHaveSomeCoffee\TheTVDbAPI\Model\EpisodeExtendedRecord;
use PHPUnit\Framework\TestCase;

/**
 * Class EpisodeTest
 *
 * @category TheTVDbAPI
 * @package  CanIHaveSomeCoffee\TheTVDbAPI\Tests
 * @author   Willem Van Iseghem (canihavesomecoffee) <theTVDbAPI@canihavesome.coffee>
 * @license  See start of document
 * @link     https://canihavesome.coffee/projects/theTVDbAPI
 */
class EpisodeTest extends TestCase
{
    public function testDirectorCreation()
    {
        $director = 'Foo Bar Baz';
        $episode = new EpisodeExtendedRecord();
        static::assertEquals(0, sizeof($episode->directors));
        $episode->setDirector($director);
        static::assertEquals(1, sizeof($episode->directors));
        static::assertContains($director, $episode->directors);
    }

    public function testDirectorRetrieval()
    {
        $director = 'Foo Bar Baz';
        $episode = new EpisodeExtendedRecord();
        static::assertEquals(0, sizeof($episode->directors));
        static::assertEquals('', $episode->getDirector());
        $episode->directors[] = $director;
        static::assertEquals($director, $episode->getDirector());
    }
}
