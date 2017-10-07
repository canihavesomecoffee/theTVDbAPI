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
 * PHP version 7.1
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
use CanIHaveSomeCoffee\TheTVDbAPI\Model\JSONError;
use CanIHaveSomeCoffee\TheTVDbAPI\Route\AuthenticationRoute;
use CanIHaveSomeCoffee\TheTVDbAPI\Route\EpisodesRoute;
use CanIHaveSomeCoffee\TheTVDbAPI\Route\LanguagesRoute;
use CanIHaveSomeCoffee\TheTVDbAPI\Route\RouteFactory;
use CanIHaveSomeCoffee\TheTVDbAPI\Route\SearchRoute;
use CanIHaveSomeCoffee\TheTVDbAPI\Route\SeriesRoute;
use CanIHaveSomeCoffee\TheTVDbAPI\Route\UpdatesRoute;
use CanIHaveSomeCoffee\TheTVDbAPI\Route\UsersRoute;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use InvalidArgumentException;

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
    const API_BASE_URI = 'https://api.thetvdb.com';

    /**
     * The actual HTTP client that will be used.
     *
     * @var Client
     */
    private $httpClient;

    /**
     * Token used for authentication purposes.
     *
     * @var string
     */
    private $token;

    /**
     * The language(s) to request results in. The first language will be
     * the primary, the others are fallback languages for when content is
     * missing in the primary language.
     *
     * @var array
     */
    protected $languages = ['en'];

    /**
     * The API version to request.
     *
     * @var string
     */
    private $version = '2.1.2';
    /**
     * Array containing the JSON errors from the last request.
     *
     * @var array
     */
    private $jsonErrors = [];
    /**
     * Array containing the pagination results from the last request.
     *
     * @var array
     */
    private $links = [];


    /**
     * TheTVDbAPI constructor.
     *
     * @param Client $client Optional parameter. If you pass one in you need to ensure that 'base_uri' and the
     *                       content-type of the headers are set in the options.
     */
    public function __construct(Client $client = null)
    {
        if ($client === null) {
            $client = new Client(
                [
                    'base_uri' => static::API_BASE_URI,
                    'verify' => false,
                    'headers' => ['Content-Type' => 'application/json']
                ]
            );
        }
        $this->httpClient = $client;
    }

    /**
     * Sets the authentication token.
     *
     * @param string $token A valid authentication token
     *
     * @return void
     */
    public function setToken(string $token = null)
    {
        $this->token = $token;
    }

    /**
     * Sets the language(s) that will be sent to the API for localized series information.
     *
     * @param array $languages An array with language abbreviation. E.g. en, nl or de.
     *
     * @return void
     */
    public function setAcceptedLanguages(array $languages)
    {
        $this->languages = $languages;
    }

    /**
     * Retrieves the language(s) that will be sent to the API for localized series information.
     *
     * @return array An array with language abbreviation. E.g. en, nl or de.
     */
    public function getAcceptedLanguages(): array
    {
        return $this->languages;
    }


    /**
     * Sets the version of the theTVDb API to call (e.g. 2.1.1).
     *
     * @param string $version Version in format x.y.z
     *
     * @return void
     * @throws InvalidArgumentException If the string doesn't match the format
     */
    public function setVersion(string $version)
    {
        if (preg_match('/^[0-9]+\.[0-9]+\.[0-9]+$/', $version) !== 1) {
            throw new InvalidArgumentException('Version does not match pattern x.y.z (where x, y, z are numbers)');
        }
        $this->version = $version;
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
     * Get users extension
     *
     * @return UsersRoute
     */
    public function users(): UsersRoute
    {
        return RouteFactory::getRouteInstance($this, UsersRoute::class);
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
        $headers = [];

        if ($this->token !== null) {
            $headers['Authorization'] = 'Bearer '.$this->token;
        }

        $languagesInOptions = (array_key_exists('headers', $options) &&
            array_key_exists('Accept-Language', $options['headers']));
        if ($this->languages !== null && $languagesInOptions === false) {
            $headers['Accept-Language'] = join(', ', $this->languages);
        }

        if ($this->version !== null) {
            $headers['Accept'] = 'application/vnd.thetvdb.v'.$this->version;
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
    public function requestHeaders($method, $path, array $options = []): array
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
    public function performAPICall($method, $path, array $options = []): Response
    {
        $options = $this->getDefaultHttpClientOptions($options);
        // Reset JSON errors.
        $this->jsonErrors = [];
        // Reset Link section.
        $this->links = [];

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
     * @throws ResourceNotFoundException
     * @throws UnauthorizedException
     * @throws Exception
     */
    public function performAPICallWithJsonResponse($method, $path, array $options = [])
    {
        $response = $this->performAPICall($method, $path, $options);

        if ($response->getStatusCode() === 200) {
            $contents = $response->getBody()->getContents();
            $json     = json_decode($contents, true);
            if ($json === null) {
                throw ParseException::decode();
            }
            // Parse errors first, if any.
            if (array_key_exists('errors', $json)) {
                // Parse error and throw appropriate exception.
                $this->parseErrorSection($json['errors']);
            }
            // Parse links, if any.
            if (array_key_exists('links', $json)) {
                $this->links = $json['links'];
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
     * Returns the JSON errors for the latest request.
     *
     * @return array An array of JSONError instances.
     */
    public function getLastJSONErrors(): array
    {
        return $this->jsonErrors;
    }

    /**
     * Returns the links from the latest request.
     *
     * @return array An array of link pages.
     */
    public function getLastLinks(): array
    {
        return $this->links;
    }

    /**
     * Parses the errors and stores them in lastJSONErrors.
     *
     * @param array $errors The JSON errors.
     *
     * @return void
     */
    private function parseErrorSection(array $errors)
    {
        if (array_key_exists('invalidFilters', $errors)) {
            $this->jsonErrors[] = new JSONError(JSONError::INVALID_FILTER, $errors['invalidFilters']);
        }
        if (array_key_exists('invalidQueryParams', $errors)) {
            $this->jsonErrors[] = new JSONError(JSONError::INVALID_QUERYPARAMS, $errors['invalidQueryParams']);
        }
        if (array_key_exists('invalidLanguage', $errors)) {
            $this->jsonErrors[] = new JSONError();
        }
    }
}
