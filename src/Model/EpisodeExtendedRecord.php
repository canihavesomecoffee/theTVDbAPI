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
 * Provides a full episode object.
 *
 * PHP version 7.4
 *
 * @category TheTVDbAPI
 * @package  CanIHaveSomeCoffee\TheTVDbAPI\Model
 * @author   Willem Van Iseghem (canihavesomecoffee) <theTVDbAPI@canihavesome.coffee>
 * @license  See start of document
 * @link     https://canihavesome.coffee/projects/theTVDbAPI
 */

declare(strict_types = 1);

namespace CanIHaveSomeCoffee\TheTVDbAPI\Model;

/**
 * Class EpisodeExtendedRecord
 *
 * @category TheTVDbAPI
 * @package  CanIHaveSomeCoffee\TheTVDbAPI\Model
 * @author   Willem Van Iseghem (canihavesomecoffee) <theTVDbAPI@canihavesome.coffee>
 * @license  See start of document
 * @link     https://canihavesome.coffee/projects/theTVDbAPI
 */
class EpisodeExtendedRecord extends EpisodeBaseRecord
{
    /**
     * List of awards this episode got.
     *
     * @var AwardBaseRecord[] Entries are of type AwardBaseRecord.
     */
    public array $awards;
    /**
     * Characters in this episode.
     *
     * @var Character[]|null Entries are of type Character.
     */
    public ?array $characters;
    /**
     * Content ratings this episode received.
     *
     * @var ContentRating[] Entries are of type ContentRating.
     */
    public array $contentRatings;
    /**
     * The network that recorded this episode.
     *
     * @var Company
     */
    public Company $network;
    /**
     * The production code for this episode.
     *
     * @var string|null
     */
    public ?string $productionCode;
    /**
     * Tag options for this episode.
     *
     * @var TagOption[]|null
     */
    public ?array $tagOptions;
    /**
     * Trailers that are available for this episode.
     *
     * @var InspirationType[] Entries are of type Trailer.
     */
    public array $trailers;
    /**
     * List of companies for this series.
     *
     * @var Company[]
     */
    public array $studios;
    /**
     * Nominations for this episode.
     *
     * @var AwardNomineeBaseRecord[]
     */
    public array $nominations;
}
