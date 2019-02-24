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
 * Class to test the ClassValidator code.
 *
 * PHP version 7.1
 *
 * @category Tests
 * @package  CanIHaveSomeCoffee\TheTVDbAPI\Tests\MultiLanguageWrapper
 * @author   Willem Van Iseghem (canihavesomecoffee) <theTVDbAPI@canihavesome.coffee>
 * @license  See start of document
 * @link     https://canihavesome.coffee/projects/theTVDbAPI
 */
declare(strict_types=1);

namespace CanIHaveSomeCoffee\TheTVDbAPI\Tests\MultiLanguageWrapper;

use CanIHaveSomeCoffee\TheTVDbAPI\Model\BasicEpisode;
use CanIHaveSomeCoffee\TheTVDbAPI\MultiLanguageWrapper\ClassValidator;
use PHPUnit\Framework\TestCase;

/**
 * Class ClassValidatorTest
 *
 * @category Tests
 * @package  CanIHaveSomeCoffee\TheTVDbAPI\Tests\MultiLanguageWrapper
 * @author   Willem Van Iseghem (canihavesomecoffee) <theTVDbAPI@canihavesome.coffee>
 * @license  See start of document
 * @link     https://canihavesome.coffee/projects/theTVDbAPI
 */
class ClassValidatorTest extends TestCase
{
    /**
     * @var ClassValidator
     */
    protected $validator;

    /**
     * {@inheritdoc}
     */
    public function setUp(): void
    {
        $this->validator = new ClassValidator();
    }

    public function testRequiredFields() {
        static::assertCount(4, $this->validator->getRequiredFields());
    }

    public function testIsValidNonMatchingClass() {
        static::assertFalse($this->validator->isValid(ClassValidator::class, $this->validator));
    }

    public function testIsValidWithSingleItem() {
        $valid_instance = new BasicEpisode();
        $valid_instance->episodeName = "Foo";
        $valid_instance->overview = "Bar";
        $invalid_instance = new BasicEpisode();

        static::assertTrue($this->validator->isValid(BasicEpisode::class, $valid_instance));
        static::assertFalse($this->validator->isValid(BasicEpisode::class, $invalid_instance));
    }

    public function testIsValidWithMultipleItems() {
        $valid_instance = new BasicEpisode();
        $valid_instance->episodeName = "Foo";
        $valid_instance->overview = "Bar";
        $invalid_instance = new BasicEpisode();
        $valid_instances = [$valid_instance, $valid_instance, $valid_instance];
        $invalid_instances = [$valid_instance, $invalid_instance, $valid_instance];

        static::assertTrue($this->validator->isValid(BasicEpisode::class, $valid_instances));
        static::assertFalse($this->validator->isValid(BasicEpisode::class, $invalid_instances));
    }

    public function testMergeWithNonExistingObject() {
        $valid_instance = new BasicEpisode();
        $valid_instance->episodeName = "Foo";
        $valid_instance->overview = "Bar";
        static::assertEquals(
            $valid_instance,
            $this->validator->merge(BasicEpisode::class, null, $valid_instance)
        );
        static::assertEquals(
            $valid_instance,
            $this->validator->merge(BasicEpisode::class, $valid_instance, null)
        );
    }

    public function testMergeWithNonMatchingClass() {
        static::assertEquals(
            $this->validator,
            $this->validator->merge(ClassValidator::class, $this->validator, $this->validator)
        );
    }

    public function testMergeWithTwoObjects() {
        $valid_instance = new BasicEpisode();
        $valid_instance->episodeName = "Foo";
        $valid_instance->overview = "Bar";
        $invalid_instance = new BasicEpisode();
        static::assertEquals(
            $valid_instance,
            $this->validator->merge(BasicEpisode::class, $invalid_instance, $valid_instance)
        );
        $invalid_instance->firstAired = "Baz";
        /** @var BasicEpisode $merged_instance */
        $merged_instance = $this->validator->merge(BasicEpisode::class, $invalid_instance, $valid_instance);
        static::assertEquals($merged_instance->episodeName, $valid_instance->episodeName);
        static::assertEquals($merged_instance->overview, $valid_instance->overview);
        static::assertEquals($merged_instance->firstAired, $invalid_instance->firstAired);
    }

    public function testMergeWithTwoArrays() {
        $valid_instance = new BasicEpisode();
        $valid_instance->episodeName = "Foo";
        $valid_instance->overview = "Bar";
        $invalid_instance = new BasicEpisode();
        $first_array = [$valid_instance, $invalid_instance, $invalid_instance, $valid_instance];
        $second_array = [$valid_instance, $valid_instance, $invalid_instance, $invalid_instance];
        $results = $this->validator->merge(BasicEpisode::class, $first_array, $second_array);
        static::assertCount(4, $results);
        static::assertEquals($valid_instance, $results[0]);
        static::assertEquals($valid_instance, $results[1]);
        static::assertEquals($invalid_instance, $results[2]);
        static::assertEquals($valid_instance, $results[3]);
    }
}
