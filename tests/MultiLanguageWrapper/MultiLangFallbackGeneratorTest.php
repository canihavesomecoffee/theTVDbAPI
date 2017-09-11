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
 * Class to test the MultiLanguageFallbackGenerator
 *
 * PHP version 7.1
 *
 * @category Tests
 * @package  CanIHaveSomeCoffee\TheTVDbAPI\Tests\MultiLanguageWrapper
 * @author   Willem Van Iseghem (canihavesomecoffee) <theTVDbAPI@canihavesome.coffee>
 * @license  See start of document
 * @link     https://canihavesome.coffee/projects/theTVDbAPI
 */
declare(strict_types = 1);

namespace CanIHaveSomeCoffee\TheTVDbAPI\Tests\MultiLanguageWrapper;

use CanIHaveSomeCoffee\TheTVDbAPI\Model\BasicEpisode;
use CanIHaveSomeCoffee\TheTVDbAPI\MultiLanguageWrapper\ClassValidator;
use CanIHaveSomeCoffee\TheTVDbAPI\MultiLanguageWrapper\MultiLanguageFallbackGenerator;
use CanIHaveSomeCoffee\TheTVDbAPI\Tests\BaseUnitTest;

/**
 * Class to test the MultiLanguageFallbackGenerator
 *
 * @category Tests
 * @package  CanIHaveSomeCoffee\TheTVDbAPI\Tests\MultiLanguageWrapper
 * @author   Willem Van Iseghem (canihavesomecoffee) <theTVDbAPI@canihavesome.coffee>
 * @license  See start of document
 * @link     https://canihavesome.coffee/projects/theTVDbAPI
 */
class MultiLangFallbackGeneratorTest extends BaseUnitTest
{
    public function testConstructor() {
        $validator = new ClassValidator();
        $instance = new MultiLanguageFallbackGenerator($validator);
        static::assertObjectHasAttribute('validator', $instance);
        static::assertAttributeEquals($validator, 'validator', $instance);
    }

    public function testCreateWithNoMerge() {
        $languages = ['en'];
        $class = BasicEpisode::class;
        $instance = new BasicEpisode();
        $validator = $this->createMock(ClassValidator::class);
        $validator->expects(static::never())->method('merge');
        $validator->expects(static::once())->method('isValid')->with($class, $instance)->willReturn(true);
        $closure = $this->getMockBuilder(\stdClass::class)->setMethods(['__invoke'])->getMock();
        $closure->expects(static::once())->method('__invoke')->with($languages[0])->willReturn($instance);
        /** @var ClassValidator $validator */
        $generator = new MultiLanguageFallbackGenerator($validator);
        /** @var \Closure $closure */
        $result = $generator->create(\Closure::fromCallable($closure), $class, $languages, false);
        static::assertInstanceOf($class, $result);
        static::assertEquals($instance, $result);
    }

    public function testCreateWithMerge() {
        $languages = ['en', 'nl'];
        $class = BasicEpisode::class;
        $instance = new BasicEpisode();
        $null_instance = new BasicEpisode();
        $validator = $this->createMock(ClassValidator::class);
        $validator->expects(static::exactly(2))->method('merge')->withConsecutive(
            [$class, null, $null_instance],
            [$class, $null_instance, $instance]
        )->willReturn($null_instance, $instance);
        $validator->expects(static::exactly(2))->method('isValid')->withConsecutive(
            [$class, $null_instance],
            [$class, $instance]
        )->willReturn(false, true);
        $closure = $this->getMockBuilder(\stdClass::class)->setMethods(['__invoke'])->getMock();
        $closure->expects(static::exactly(2))->method('__invoke')->withConsecutive(
            [$languages[0]],
            [$languages[1]]
        )->willReturn($null_instance, $instance);
        /** @var ClassValidator $validator */
        $generator = new MultiLanguageFallbackGenerator($validator);
        /** @var \Closure $closure */
        $result = $generator->create(\Closure::fromCallable($closure), $class, $languages, true);
        static::assertInstanceOf($class, $result);
        static::assertEquals($instance, $result);
    }
}
