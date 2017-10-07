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
 * This is a wrapper class around the main library class in order to provide fallback language support. Currently the
 * API of theTVDb does not offer a "fallback", returning null values instead if a translation is missing. This wrapper
 * library solves that by checking on a number of important fields and making a second request if one of those fields
 * is empty, using the fallback language(s).
 *
 * PHP version 7.1
 *
 * @category TheTVDbAPI
 * @package  CanIHaveSomeCoffee\TheTVDbAPI
 * @author   Willem Van Iseghem (canihavesomecoffee) <theTVDbAPI@canihavesome.coffee>
 * @license  See start of document
 * @link     https://canihavesome.coffee/projects/theTVDbAPI
 */
declare(strict_types = 1);

namespace CanIHaveSomeCoffee\TheTVDbAPI\MultiLanguageWrapper;

use CanIHaveSomeCoffee\TheTVDbAPI\MultiLanguageWrapper\Route\EpisodesRouteLanguageFallback;
use CanIHaveSomeCoffee\TheTVDbAPI\MultiLanguageWrapper\Route\SearchRouteLanguageFallback;
use CanIHaveSomeCoffee\TheTVDbAPI\MultiLanguageWrapper\Route\SeriesRouteLanguageFallback;
use CanIHaveSomeCoffee\TheTVDbAPI\Route\EpisodesRoute;
use CanIHaveSomeCoffee\TheTVDbAPI\Route\RouteFactory;
use CanIHaveSomeCoffee\TheTVDbAPI\Route\SearchRoute;
use CanIHaveSomeCoffee\TheTVDbAPI\Route\SeriesRoute;
use CanIHaveSomeCoffee\TheTVDbAPI\TheTVDbAPI;
use GuzzleHttp\Client;

/**
 * Class TheTVDbAPILanguageFallback
 *
 * @category TheTVDbAPI
 * @package  CanIHaveSomeCoffee\TheTVDbAPI\MultiLanguageWrapper
 * @author   Willem Van Iseghem (canihavesomecoffee) <theTVDbAPI@canihavesome.coffee>
 * @license  See start of document
 * @link     https://canihavesome.coffee/projects/theTVDbAPI
 */
class TheTVDbAPILanguageFallback extends TheTVDbAPI
{
    /**
     * Implementation of the class validator.
     *
     * @var MultiLanguageFallbackGenerator
     */
    private $generator;


    /**
     * TheTVDbAPILanguageFallback constructor.
     *
     * @param ClassValidatorInterface $classValidator Optional parameter. If you want more fields to be checked for
     *                                                null values when performing requests, pass in your own
     *                                                implementation.
     * @param Client                  $client         Optional parameter. If you pass one in you need to ensure that
     *                                                'base_uri' and the content-type of the headers are set in the
     *                                                options.
     */
    public function __construct(ClassValidatorInterface $classValidator = null, Client $client = null)
    {
        parent::__construct($client);
        if ($classValidator === null) {
            $classValidator = new ClassValidator();
        }
        $this->generator = new MultiLanguageFallbackGenerator($classValidator);
    }

    /**
     * Gets the generator
     *
     * @return MultiLanguageFallbackGenerator
     */
    public function getGenerator(): MultiLanguageFallbackGenerator
    {
        return $this->generator;
    }

    /**
     * Get episodes extension
     *
     * @return EpisodesRoute
     */
    public function episodes(): EpisodesRoute
    {
        return RouteFactory::getRouteInstance($this, EpisodesRouteLanguageFallback::class);
    }

    /**
     * Get series extension
     *
     * @return SeriesRoute
     */
    public function series(): SeriesRoute
    {
        return RouteFactory::getRouteInstance($this, SeriesRouteLanguageFallback::class);
    }

    /**
     * Get search extension
     *
     * @return SearchRoute
     */
    public function search(): SearchRoute
    {
        return RouteFactory::getRouteInstance($this, SearchRouteLanguageFallback::class);
    }
}
