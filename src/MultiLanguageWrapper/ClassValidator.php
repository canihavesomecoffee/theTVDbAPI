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
 * PHP version 7.1
 *
 * @category TheTVDbAPI
 * @package  CanIHaveSomeCoffee\TheTVDbAPI\MultiLanguageWrapper
 * @author   Willem Van Iseghem (canihavesomecoffee) <theTVDbAPI@canihavesome.coffee>
 * @license  See start of document
 * @link     https://canihavesome.coffee/projects/theTVDbAPI
 */
declare(strict_types = 1);

namespace CanIHaveSomeCoffee\TheTVDbAPI\MultiLanguageWrapper;

use CanIHaveSomeCoffee\TheTVDbAPI\Model\BasicEpisode;
use CanIHaveSomeCoffee\TheTVDbAPI\Model\BasicSeries;
use CanIHaveSomeCoffee\TheTVDbAPI\Model\Episode;
use CanIHaveSomeCoffee\TheTVDbAPI\Model\Series;

/**
 * Class ClassValidator
 *
 * @category TheTVDbAPI
 * @package  CanIHaveSomeCoffee\TheTVDbAPI\MultiLanguageWrapper
 * @author   Willem Van Iseghem (canihavesomecoffee) <theTVDbAPI@canihavesome.coffee>
 * @license  See start of document
 * @link     https://canihavesome.coffee/projects/theTVDbAPI
 */
class ClassValidator implements ClassValidatorInterface
{


    /**
     * Checks if for a given instance the required fields are not null.
     *
     * @param string       $returnTypeClass The class type of the instance.
     * @param object|array $instance        The instance to check.
     *
     * @return bool
     */
    public function isValid(string $returnTypeClass, $instance): bool
    {
        if (array_key_exists($returnTypeClass, $this->getRequiredFields()) === false) {
            return false;
        }
        foreach ($this->getRequiredFields()[$returnTypeClass] as $property) {
            if (is_array($instance)) {
                foreach ($instance as $item) {
                    if ($item->{$property} === null) {
                        return false;
                    }
                }
            } elseif ($instance->{$property} === null) {
                return false;
            }
        }
        return true;
    }

    /**
     * Merges two instances together by replacing missing values that are required.
     *
     * @param string       $returnTypeClass  The class type of the instances.
     * @param object|array $existingInstance The instance that already exists.
     * @param object|array $newInstance      The instance to be merged.
     *
     * @return mixed
     */
    public function merge(string $returnTypeClass, $existingInstance, $newInstance)
    {
        if ($existingInstance === null) {
            return $newInstance;
        }
        if (array_key_exists($returnTypeClass, $this->getRequiredFields()) && $newInstance !== null) {
            foreach ($this->getRequiredFields()[$returnTypeClass] as $property) {
                if (is_array($existingInstance)) {
                    $existingInstanceSize = sizeof($existingInstance);
                    for ($index = 0; $index < $existingInstanceSize; $index++) {
                        if ($existingInstance[$index]->{$property} === null) {
                            $existingInstance[$index]->{$property} = $newInstance[$index]->{$property};
                        }
                    }
                } elseif ($existingInstance->{$property} === null) {
                    $existingInstance->{$property} = $newInstance->{$property};
                }
            }
        }
        return $existingInstance;
    }

    /**
     * Returns an array which specifies which fields of which class are mandatory for merging.
     *
     * @return array
     */
    public function getRequiredFields(): array
    {
        return [
            BasicEpisode::class => ['episodeName', 'overview'],
            Episode::class => ['episodeName', 'overview'],
            BasicSeries::class => ['seriesName', 'overview'],
            Series::class => ['seriesName', 'overview']
        ];
    }
}
