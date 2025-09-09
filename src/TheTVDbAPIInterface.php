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
 * Interface for the theTVDbAPI client.
 *
 * PHP version 7.4
 *
 * @category TheTVDbAPI
 * @package  CanIHaveSomeCoffee\TheTVDbAPI
 * @author   Willem Van Iseghem (canihavesomecoffee) <theTVDbAPI@canihavesome.coffee>
 * @license  See start of document
 * @link     https://canihavesome.coffee/projects/theTVDbAPI
 */
declare(strict_types = 1);

namespace CanIHaveSomeCoffee\TheTVDbAPI;

use CanIHaveSomeCoffee\TheTVDbAPI\Route\AuthenticationRoute;
use CanIHaveSomeCoffee\TheTVDbAPI\Route\EpisodesRoute;
use Exception;
use GuzzleHttp\Psr7\Response;
use CanIHaveSomeCoffee\TheTVDbAPI\Exception\ParseException;
use CanIHaveSomeCoffee\TheTVDbAPI\Exception\ResourceNotFoundException;
use CanIHaveSomeCoffee\TheTVDbAPI\Exception\UnauthorizedException;
use CanIHaveSomeCoffee\TheTVDbAPI\Route\ArtworkRoute;
use CanIHaveSomeCoffee\TheTVDbAPI\Route\LanguagesRoute;
use CanIHaveSomeCoffee\TheTVDbAPI\Route\SearchRoute;
use CanIHaveSomeCoffee\TheTVDbAPI\Route\SeriesRoute;
use CanIHaveSomeCoffee\TheTVDbAPI\Route\UpdatesRoute;

/**
 * Interface TheTVDbAPIInterface
 *
 * @category TheTVDbAPI
 * @package  CanIHaveSomeCoffee\TheTVDbAPI
 * @author   Willem Van Iseghem (canihavesomecoffee) <theTVDbAPI@canihavesome.coffee>
 * @license  See start of document
 * @link     https://canihavesome.coffee/projects/theTVDbAPI
 */
interface TheTVDbAPIInterface
{


    /**
     * Sets the authentication token.
     *
     * @param string|null $token A valid token.
     *
     * @return void
     */
    public function setToken(?string $token = null);

    /**
     * Get authentication extension
     *
     * @return AuthenticationRoute
     */
    public function authentication(): AuthenticationRoute;

    /**
     * Get language extension
     *
     * @return LanguagesRoute
     */
    public function languages(): LanguagesRoute;

    /**
     * Get episodes extension
     *
     * @return EpisodesRoute
     */
    public function episodes(): EpisodesRoute;

    /**
     * Get series extension
     *
     * @return SeriesRoute
     */
    public function series(): SeriesRoute;

    /**
     * Get search extension
     *
     * @return SearchRoute
     */
    public function search(): SearchRoute;

    /**
     * Get updates extension
     *
     * @return UpdatesRoute
     */
    public function updates(): UpdatesRoute;

    /**
     * Get artwork extension
     *
     * @return ArtworkRoute
     */
    public function artwork(): ArtworkRoute;

    /**
     * Makes a call to the API and return headers only.
     *
     * @param string $method  HTTP Method (post, getUserData, put, etc.)
     * @param string $path    Path to the API call
     * @param array  $options HTTP Client options
     *
     * @return array
     * @throws UnauthorizedException
     * @throws ResourceNotFoundException
     */
    public function requestHeaders(string $method, string $path, array $options = []): array;

    /**
     * Perform an API call to theTVDb.
     *
     * @param string $method  HTTP Method (post, getUserData, put, etc.)
     * @param string $path    Path to the API call
     * @param array  $options HTTP Client options
     *
     * @return Response
     * @throws UnauthorizedException
     * @throws ResourceNotFoundException
     */
    public function performAPICall(string $method, string $path, array $options = []): Response;

    /**
     * Perform an API call to theTVDb and return a JSON response
     *
     * @param string $method  HTTP Method (post, getUserData, put, etc.)
     * @param string $path    Path to the API call
     * @param array  $options HTTP Client options
     *
     * @return mixed
     * @throws ParseException
     * @throws UnauthorizedException
     * @throws ResourceNotFoundException
     * @throws Exception
     */
    public function performAPICallWithJsonResponse(string $method, string $path, array $options = []);

    /**
     * Return the primary language to get translations for.
     *
     * @return string
     */
    public function getPrimaryLanguage(): string;

    /**
     * Return the secondary fallback language.
     *
     * @return string
     */
    public function getSecondaryLanguage(): string;


}
