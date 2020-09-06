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
 * Class that generates multiple requests for language fallback purposes.
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

use CanIHaveSomeCoffee\TheTVDbAPI\Exception\ResourceNotFoundException;
use Closure;

/**
 * Class MultiLanguageFallbackGenerator
 *
 * @category TheTVDbAPI
 * @package  CanIHaveSomeCoffee\TheTVDbAPI\MultiLanguageWrapper
 * @author   Willem Van Iseghem (canihavesomecoffee) <theTVDbAPI@canihavesome.coffee>
 * @license  See start of document
 * @link     https://canihavesome.coffee/projects/theTVDbAPI
 */
class MultiLanguageFallbackGenerator
{
    /**
     * The validator for the classes
     *
     * @var ClassValidatorInterface
     */
    private $validator;


    /**
     * MultiLanguageFallbackGenerator constructor.
     *
     * @param ClassValidatorInterface $validator The implementation to validate and merge classes
     */
    public function __construct(ClassValidatorInterface $validator)
    {
        $this->validator = $validator;
    }

    /**
     * Creates an object using the provided closure, and keeps using fallback languages while the object isn't valid.
     *
     * @param Closure $performRequest  The closure that calls the API and returns an object of the provided class. The
     *                                 function call must accept only one parameter: the language for the request.
     * @param string  $returnTypeClass The type of class instance that should be returned.
     * @param array   $languages       The languages that should be tried.
     * @param bool    $merge           Merge the results in different languages together?
     * @param null    $defaultReturn   The default return value.
     *
     * @return mixed
     */
    public function create(
        Closure $performRequest,
        string $returnTypeClass,
        array $languages,
        bool $merge = false,
        $defaultReturn = null
    ) {
        $languageIdx = 0;
        $returnValue = $defaultReturn;
        $langLength  = sizeof($languages);
        do {
            try {
                $result = $performRequest($languages[$languageIdx]);
            } catch (ResourceNotFoundException $unused) {
                $result = null;
            }
            $languageIdx++;
            if ($languageIdx > 0 && $merge) {
                $returnValue = $this->validator->merge($returnTypeClass, $returnValue, $result);
            } else {
                $returnValue = $result;
            }
        } while ($this->validator->isValid($returnTypeClass, $result) === false && $languageIdx < $langLength);
        return $returnValue;
    }
}
