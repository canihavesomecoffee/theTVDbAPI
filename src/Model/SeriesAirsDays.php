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
 *
 *
 * PHP version 7.4
 *
 * @category TheTVDbAPI
 * @package  CanIHaveSomeCoffee\TheTVDbAPI\Model
 * @author   Willem Van Iseghem (canihavesomecoffee) <theTVDbAPI@canihavesome.coffee>
 * @license  See start of document
 * @link     https://canihavesome.coffee/projects/theTVDbAPI
 */

declare(strict_types=1);

namespace CanIHaveSomeCoffee\TheTVDbAPI\Model;

/**
 * Class SeriesAirsDays
 *
 * @package CanIHaveSomeCoffee\TheTVDbAPI\Model
 */
class SeriesAirsDays
{
    /**
     * Does the episode air on friday?
     *
     * @var boolean
     */
    public bool $friday;
    /**
     * Does the episode air on monday?
     *
     * @var boolean
     */
    public bool $monday;
    /**
     * Does the episode air on saturday?
     *
     * @var boolean
     */
    public bool $saturday;
    /**
     * Does the episode air on sunday?
     *
     * @var boolean
     */
    public bool $sunday;
    /**
     * Does the episode air on thursday?
     *
     * @var boolean
     */
    public bool $thursday;
    /**
     * Does the episode air on tuesday?
     *
     * @var boolean
     */
    public bool $tuesday;
    /**
     * Does the episode air on wednesday?
     *
     * @var boolean
     */
    public bool $wednesday;


    /**
     * Checks if all fields of the week have been set.
     *
     * @return bool
     */
    public function airsAllDays()
    {
        return $this->monday && $this->tuesday && $this->wednesday && $this->thursday && $this->friday &&
            $this->saturday && $this->sunday;
    }

    /**
     * Checks if no days are enabled as air day.
     *
     * @return bool
     */
    public function airsNoDays()
    {
        return !$this->monday && ! $this->tuesday && !$this->wednesday && !$this->thursday && !$this->friday &&
            !$this->saturday && !$this->sunday;
    }


}
