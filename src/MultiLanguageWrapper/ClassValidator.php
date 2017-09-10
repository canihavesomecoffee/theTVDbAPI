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
     * @param string       $return_type_class The class type of the instance.
     * @param object|array $instance          The instance to check.
     *
     * @return bool
     */
    public function isValid(string $return_type_class, $instance): bool
    {
        if (array_key_exists($return_type_class, $this->getRequiredFields()) === false) {
            return false;
        }
        foreach ($this->getRequiredFields()[$return_type_class] as $property) {
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
     * @param string       $return_type_class The class type of the instances.
     * @param object|array $existing_instance The instance that already exists.
     * @param object|array $new_instance      The instance to be merged.
     *
     * @return mixed
     */
    public function merge(string $return_type_class, $existing_instance, $new_instance)
    {
        if ($existing_instance === null) {
            return $new_instance;
        }
        if (array_key_exists($return_type_class, $this->getRequiredFields()) && $new_instance !== null) {
            foreach ($this->getRequiredFields()[$return_type_class] as $property) {
                if (is_array($existing_instance)) {
                    for ($index = 0; $index < sizeof($existing_instance); $index++) {
                        if ($existing_instance[$index]->{$property} === null) {
                            $existing_instance[$index]->{$property} = $new_instance[$index]->{$property};
                        }
                    }
                } elseif ($existing_instance->{$property} === null) {
                    $existing_instance->{$property} = $new_instance->{$property};
                }
            }
        }
        return $existing_instance;
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
