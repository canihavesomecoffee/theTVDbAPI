<?php
/**
 * Copyright (c) 2020, Willem Van Iseghem (canihavesomecoffee) <theTVDbAPI@canihavesome.coffee>
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
 * Example to retrieve all episodes from a single show which has more than 100 episodes
 *
 * PHP version 7.4
 *
 * @category Examples
 * @author   Willem Van Iseghem (canihavesomecoffee) <theTVDbAPI@canihavesome.coffee>
 * @license  See start of document
 * @link     https://canihavesome.coffee/projects/theTVDbAPI
 */
declare(strict_types=1);

use CanIHaveSomeCoffee\TheTVDbAPI\TheTVDbAPI;

require_once __DIR__.'/../vendor/autoload.php';

$accessKey = getenv('PROJECT_KEY');

$theTVDbAPI = new TheTVDbAPI();

// Login and set the token.
$token = $theTVDbAPI->authentication()->login($accessKey);
$theTVDbAPI->setToken($token);

// Retrieve all episodes from The Big Bang Theory (> 100 episodes).
$episodes = $theTVDbAPI->series()->allEpisodes(80379);
var_dump($episodes);
