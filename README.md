# CanIHaveSomeCoffee/TheTVDbAPI

[![Packagist](https://img.shields.io/packagist/v/canihavesomecoffee/thetvdbapi.svg)](https://packagist.org/packages/canihavesomecoffee/thetvdbapi)
[![Minimum PHP Version](https://img.shields.io/badge/php-%3E%3D%207.2-green.svg)](https://php.net/)
[![Build status](https://api.travis-ci.org/canihavesomecoffee/theTVDbAPI.svg?branch=master)](https://travis-ci.org/canihavesomecoffee/theTVDbAPI)
[![codecov](https://codecov.io/gh/canihavesomecoffee/theTVDbAPI/branch/master/graph/badge.svg)](https://codecov.io/gh/canihavesomecoffee/theTVDbAPI)

This is an API client for the thetvdb.com website. It's using the 3rd, improved API version (RESTful). In order to be
 able to access this API you'll have to register on theTVDb first.

This API implementation can be considered a mix between adrenth/thetvdb2 and Moinax/TvDb.

## API Key Registration

To use this PHP package, you need to request an API Key from the thetvdb.com website: [https://thetvdb.com/dashboard/account/apikeys](https://thetvdb.com/dashboard/account/apikeys).

To use the API, there are a few guidelines (taken from [API information page](https://thetvdb.com/api-information)):

> Free, open source projects are welcome to use our API, images, and data as long as they provide attribution including a link to our site. If you sell your app, provide subscription based services, or sell advertising on your app or website, we consider you a commercial project. Commercial projects, both publicly and privately available to at least 10 users, are required to arrange a commercial license. Commercial projects are able to use our API without restriction during development. We often exclude projects from licensing fees until they are financially successful, but this is solely our decision.
>
> We reserve the right to change our interfaces, fees, or licensing terms at any point without notice.

Please keep these guidelines in mind when making use of this API client. For information on how to comply with attribution, please refer to the page linked above.

## Installation

Install this package using composer:

````
$ composer require canihavesomecoffee/thetvdbapi
````

## Documentation

The official API documentation can be found here: [https://api.thetvdb.com/swagger]().

For usage examples of the API, please refer to the examples folder.

### Authentication

````
$theTVDbAPI = new \CanIHaveSomeCoffee\TheTVDbAPI\TheTVDbAPI();
$theTVDbAPI->setLanguage(['nl']);
// or set Dutch with English as fallback language
$theTVDbAPI->setLanguage['nl', 'en']);

// Obtain a token. There are two options:
// 1. Series data only
$token = $theTVDbAPI->authentication()->login($apiKey);
// 2. Series and user options
$token = $theTVDbAPI->authentication()->login($apiKey, $username, $userKey);

// Set the token
$theTVDbAPI->setToken($token);
// Or refresh token
$theTVDbAPI->refreshToken();
````

### Routes

The `TheTVDbAPI` offers access to the same routes that the API provides. A few usage examples are listed below:

#### Authentication
````
$theTVDbAPI->authentication()->login($apiKey);
$theTVDbAPI->authentication()->refreshToken();
````

#### Languages
````
$theTVDbAPI->languages()->all();
$theTVDbAPI->languages()->get($languageId);
````

#### Episodes
````
$theTVDbAPI->episodes()->get($episodeId);
````

#### Series
````
$theTVDbAPI->series()->get($seriesId);
$theTVDbAPI->series()->getActors($seriesId);
$theTVDbAPI->series()->getEpisodes($seriesId);
$theTVDbAPI->series()->getImages($seriesId);
$theTVDbAPI->series()->getLastModified($seriesId);
````

#### Search
````
$theTVDbAPI->search()->seriesByName('lost');
$theTVDbAPI->search()->seriesByImdbId('tt2243973');
$theTVDbAPI->search()->seriesByZap2itId('EP015679352');
$theTVDbAPI->search()->seriesBySlug('lost');
````

#### Updates

Fetch a list of Series that have been recently updated:

````
$theTVDbAPI->updates()->query($fromTime, $toTime);
````

#### Users

````
$theTVDbAPI->users()->get();
$theTVDbAPI->users()->getFavorites();
$theTVDbAPI->users()->addFavorite($identifier);
$theTVDbAPI->users()->removeFavorite($identifier);
$theTVDbAPI->users()->getRatings();
$theTVDbAPI->users()->addRating($type, $itemId, $rating);
$theTVDbAPI->users()->updateRating($type, $itemId, $rating);
$theTVDbAPI->users()->removeRating($type, $itemId);
````

## Contributing

While the aim is to provide a ready-to-use API, it's possible that things are missing or outdated. If you think 
something is missing or you want to add something, feel free to open up an issue, or even better, make a Pull Request 
(PR) with a fix or improvement. The PR's will be gladly accepted in order to improve this client API.
