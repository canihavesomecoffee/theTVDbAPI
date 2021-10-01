# CanIHaveSomeCoffee/TheTVDbAPI

[![Packagist](https://img.shields.io/packagist/v/canihavesomecoffee/thetvdbapi.svg)](https://packagist.org/packages/canihavesomecoffee/thetvdbapi)
[![Minimum PHP Version](https://img.shields.io/packagist/php-v/canihavesomecoffee/theTVDbAPI)](https://php.net/)
[![Build status](https://api.travis-ci.org/canihavesomecoffee/theTVDbAPI.svg?branch=master)](https://travis-ci.org/canihavesomecoffee/theTVDbAPI)
[![codecov](https://codecov.io/gh/canihavesomecoffee/theTVDbAPI/branch/master/graph/badge.svg)](https://codecov.io/gh/canihavesomecoffee/theTVDbAPI)

This is an API client for the thetvdb.com website. It's using the **4th** version of the theTVDb API. In order to be
 able to access this API you'll have to register on theTVDb first and obtain a project key.

## API Key Registration

To use this PHP package, you need to request an API Key from the thetvdb.com website: [https://thetvdb.com/dashboard/account/apikeys](https://thetvdb.com/dashboard/account/apikeys).

> We have two models for API access, both that provide funding that allows us to continue running and improving the site. The first is our negotiated license model, which allows commercial companies to negotiate access with us. The second is a user-subscription model, which allows end users to access the API if they are subscribed. We reserve the right to change our interfaces, fees, or licensing terms at any point without notice.

To create an API key, create an account and visit the API keys page on your dashboard.

## Installation

Install this package using composer:

````
$ composer require canihavesomecoffee/thetvdbapi
````

## Documentation

The official API documentation can be found here: [https://thetvdb.github.io/v4-api/]().

For usage examples of the API, please refer to the examples' folder.

### API-wide translations

You can pass a primary and secondary (fallback) language to the API constructor.

For example, if you want translations in Dutch, but a fallback to English if no Dutch translations exist, you can set
this as follows:

````
$theTVDbAPI = new \CanIHaveSomeCoffee\TheTVDbAPI\TheTVDbAPI("nld", "eng");
````

By default, the primary language is set to English without a fallback language.

### Authentication

````
$theTVDbAPI = new \CanIHaveSomeCoffee\TheTVDbAPI\TheTVDbAPI();

// Obtain a token. Optionally you can pass a user pin through as well.
$token = $theTVDbAPI->authentication()->login($apiKey);

// Set the token
$theTVDbAPI->setToken($token);
````

### Routes

The `TheTVDbAPI` offers access to the same routes that the API provides. A few usage examples are listed below:

#### Authentication
````
$theTVDbAPI->authentication()->login($apiKey);
// or in case it's a project with user-specific subscriptions
$theTVDbAPI->authentication()->login($apiKey, $pin);
````

#### Languages
````
$theTVDbAPI->languages()->all();
````

#### Episodes
````
$theTVDbAPI->episodes()->simple(6347388);
$theTVDbAPI->episodes()->extended(8366715);
$theTVDbAPI->episodes()->translations(8366715, "nld");
````

#### Series
````
$theTVDbAPI->series()->list();
$theTVDbAPI->series()->simple(280258);
$theTVDbAPI->series()->extended(280258);
$theTVDbAPI->series()->translate(280258);
$theTVDbAPI->series()->episodes(280258); // Paginated
$theTVDbAPI->series()->allEpisodes(280258); // All episodes, translated
````

#### Search
````
$theTVDbAPI->search()->search("Ideale");
$theTVDbAPI->search()->search("Ideale", ["year" => 2014]);
$theTVDbAPI->search()->search("Ideale Wereld", ["type" => "series"]);
````

#### Updates

Fetch a list of entities that have been recently updated:

````
$now = new DateTime();
$now->sub(new DateInterval("PT2H"));
$theTVDbAPI->updates()->query($now);
````

Some wrapper methods are available to restrict results:
````
$now = new DateTime();
$now->sub(new DateInterval("PT2H"));
$theTVDbAPI->updates()->fetchSerieUpdates($now);
$theTVDbAPI->updates()->fetchEpisodeUpdates($now);
````

#### Artwork
````
$theTVDbAPI->artwork()->simple(62001533);
$theTVDbAPI->artwork()->extended(62001533);
$theTVDbAPI->artwork()->statuses();
$theTVDbAPI->artwork()->types();
````

## Contributing

While the aim is to provide a ready-to-use API, it's possible that things are missing or outdated. If you think 
something is missing, or you want to add something, feel free to open up an issue, or even better, make a Pull Request 
(PR) with a fix or improvement. The PR's will be gladly accepted in order to improve this client API.
