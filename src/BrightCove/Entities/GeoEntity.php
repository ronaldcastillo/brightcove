<?php

namespace ContemporaryVA\BrightCove\Entities;

class GeoEntity extends AbstractEntity
{

    /**
     * @var $countries array of strings    ISO 3166 list of 2-letter codes for countries that will be whitelisted or
     *      blacklisted for viewing the video
     */
    public $countries;
    /**
     * @var $excludeCountries boolean    if true, country array is treated as a list of countries excluded from viewing
     */
    public $excludeCountries;
    /**
     * @var $restricted boolean    whether geo-restriction is enabled for thie video
     */
    public $restricted;

}