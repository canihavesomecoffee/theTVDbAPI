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
 * The main class for this library.
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

use CanIHaveSomeCoffee\TheTVDbAPI\Exception\ParseException;
use CanIHaveSomeCoffee\TheTVDbAPI\Exception\ResourceNotFoundException;
use CanIHaveSomeCoffee\TheTVDbAPI\Exception\UnauthorizedException;
use CanIHaveSomeCoffee\TheTVDbAPI\Model\Links;
use CanIHaveSomeCoffee\TheTVDbAPI\Route\AuthenticationRoute;
use CanIHaveSomeCoffee\TheTVDbAPI\Route\ArtworkRoute;
use CanIHaveSomeCoffee\TheTVDbAPI\Route\EpisodesRoute;
use CanIHaveSomeCoffee\TheTVDbAPI\Route\LanguagesRoute;
use CanIHaveSomeCoffee\TheTVDbAPI\Route\RouteFactory;
use CanIHaveSomeCoffee\TheTVDbAPI\Route\SearchRoute;
use CanIHaveSomeCoffee\TheTVDbAPI\Route\SeriesRoute;
use CanIHaveSomeCoffee\TheTVDbAPI\Route\UpdatesRoute;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use Symfony\Component\Serializer\Exception\ExceptionInterface;

/**
 * Class TheTVDbAPI
 *
 * @category TheTVDbAPI
 * @package  CanIHaveSomeCoffee\TheTVDbAPI
 * @author   Willem Van Iseghem (canihavesomecoffee) <theTVDbAPI@canihavesome.coffee>
 * @license  See start of document
 * @link     https://canihavesome.coffee/projects/theTVDbAPI
 */
class TheTVDbAPI implements TheTVDbAPIInterface
{
    /**
     * Base URI to the API.
     *
     * @type string
     */
    const API_BASE_URI = 'https://api4.thetvdb.com/v4/';

    /**
     * The actual HTTP client that will be used.
     *
     * @var Client
     */
    private Client $httpClient;

    /**
     * Token used for accessing the API.
     *
     * @var string|null
     */
    private ?string $token;

    /**
     * Property used to control pagination (if any).
     *
     * @var Links|null
     */
    private ?Links $links = null;

    /**
     * Primary language to use for retrieving series.
     *
     * @var string
     */
    private string $primaryLanguage;
    /**
     * Secondary language to use as fallback.
     *
     * @var string
     */
    private string $secondaryLanguage;


    /**
     * TheTVDbAPI constructor.
     *
     * @param string      $primaryLanguage   The primary language to retrieve data in.
     * @param string      $secondaryLanguage The fallback languages.
     * @param Client|null $client            Optional parameter. If you pass one in you need to ensure that 'base_uri'
     *                                       and the content-type of the headers are set in the options.
     */
    public function __construct(string $primaryLanguage = "eng", string $secondaryLanguage = "", ?Client $client = null)
    {
        $this->primaryLanguage   = $primaryLanguage;
        $this->secondaryLanguage = $secondaryLanguage;
        if ($client === null) {
            $this->httpClient = new Client(
                [
                    'base_uri' => static::API_BASE_URI,
                    'verify'   => false,
                    'headers'  => ['accept' => 'application/json'],
                ]
            );
        } else {
            $this->httpClient = $client;
        }
    }

    /**
     * Sets the authentication token.
     *
     * @param string|null $token A valid authentication token
     *
     * @return void
     */
    public function setToken(?string $token = null)
    {
        $this->token = $token;
    }

    /**
     * Get the links currently set.
     *
     * @return Links|null
     */
    public function getLinks(): ?Links
    {
        return $this->links;
    }

    /**
     * Returns the authentication route object.
     *
     * @return AuthenticationRoute
     */
    public function authentication(): AuthenticationRoute
    {
        return RouteFactory::getRouteInstance($this, AuthenticationRoute::class);
    }

    /**
     * Get language extension
     *
     * @return LanguagesRoute
     */
    public function languages(): LanguagesRoute
    {
        return RouteFactory::getRouteInstance($this, LanguagesRoute::class);
    }

    /**
     * Get episodes extension
     *
     * @return EpisodesRoute
     */
    public function episodes(): EpisodesRoute
    {
        return RouteFactory::getRouteInstance($this, EpisodesRoute::class);
    }

    /**
     * Get series extension
     *
     * @return SeriesRoute
     */
    public function series(): SeriesRoute
    {
        return RouteFactory::getRouteInstance($this, SeriesRoute::class);
    }

    /**
     * Get search extension
     *
     * @return SearchRoute
     */
    public function search(): SearchRoute
    {
        return RouteFactory::getRouteInstance($this, SearchRoute::class);
    }

    /**
     * Get updates extension
     *
     * @return UpdatesRoute
     */
    public function updates(): UpdatesRoute
    {
        return RouteFactory::getRouteInstance($this, UpdatesRoute::class);
    }

    /**
     * Get artwork extension
     *
     * @return ArtworkRoute
     */
    public function artwork(): ArtworkRoute
    {
        return RouteFactory::getRouteInstance($this, ArtworkRoute::class);
    }

    /**
     * Returns the default client options.
     *
     * @param array $options A list of options to start with (optional)
     *
     * @return array An array containing the passed in options, as well as the added ones
     */
    private function getDefaultHttpClientOptions(array $options = []): array
    {
        $headers = [
            'Accept'       => 'application/json',
            'Content-Type' => 'application/json',
        ];

        if ($this->token !== null) {
            $headers['Authorization'] = 'Bearer '.$this->token;
        }

        $options['http_errors'] = false;

        return array_merge_recursive(['headers' => $headers], $options);
    }

    /**
     * Makes a call to the API and return headers only.
     *
     * @param string $method  HTTP Method (post, getUserData, put, etc.)
     * @param string $path    Path to the API call
     * @param array  $options HTTP Client options
     *
     * @return array
     * @throws ResourceNotFoundException
     * @throws UnauthorizedException
     */
    public function requestHeaders(string $method, string $path, array $options = []): array
    {
        $options = $this->getDefaultHttpClientOptions($options);

        /* @type Response $response */
        $response = $this->httpClient->{$method}($path, $options);

        if ($response->getStatusCode() === 401) {
            throw UnauthorizedException::invalidToken();
        } elseif ($response->getStatusCode() === 404) {
            throw ResourceNotFoundException::notFound($path, $options);
        }

        return $response->getHeaders();
    }

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
    public function performAPICall(string $method, string $path, array $options = []): Response
    {
        $options = $this->getDefaultHttpClientOptions($options);

        /* @type Response $response */
        $response = $this->httpClient->{$method}($path, $options);

        if ($response->getStatusCode() === 401) {
            throw UnauthorizedException::invalidToken();
        } elseif ($response->getStatusCode() === 404) {
            throw ResourceNotFoundException::notFound($path, $options);
        }

        return $response;
    }

    /**
     * Perform an API call to theTVDb and return a JSON response
     *
     * @param string $method  HTTP Method (post, getUserData, put, etc.)
     * @param string $path    Path to the API call
     * @param array  $options HTTP Client options
     *
     * @return mixed
     * @throws ParseException
     * @throws ResourceNotFoundException
     * @throws UnauthorizedException
     * @throws ExceptionInterface
     */
    public function performAPICallWithJsonResponse(string $method, string $path, array $options = [])
    {
        $response = $this->performAPICall($method, $path, $options);

        if ($response->getStatusCode() === 200) {
            $contents = $response->getBody()->getContents();
            $json     = json_decode($contents, true);
            if ($json === null) {
                throw ParseException::decode();
            }
            // Parse links, if any.
            if (array_key_exists('links', $json)) {
                $this->links = DataParser::parseData($json['links'], Links::class);
            } else {
                $this->links = null;
            }
            if (array_key_exists('data', $json) === false) {
                return $json;
            }
            return $json['data'];
        }

        throw new Exception(
            sprintf(
                'Got status code %d from service at path %s',
                $response->getStatusCode(),
                $path
            )
        );
    }

    /**
     * Return the primary language to get translations for.
     *
     * @return string
     */
    public function getPrimaryLanguage(): string
    {
        return $this->primaryLanguage;
    }

    /**
     * Return the secondary fallback language.
     *
     * @return string
     */
    public function getSecondaryLanguage(): string
    {
        return $this->secondaryLanguage;
    }


}
