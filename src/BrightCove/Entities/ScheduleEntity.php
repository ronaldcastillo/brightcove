<?php

namespace ContemporaryVA\BrightCove\Entities;

/**
 * Class ScheduleEntity
 *
 * @extends AbstractEntity
 * @package ContemporaryVA\BrightCove\Entities
 */
class ScheduleEntity extends AbstractEntity
{

    /**
     * @var    $endsAt    ISO 8601 date-time string[7-1]    date-time when video will become unavailable
     */
    public $endsAt;
    /**
     * @var    $startsAt    ISO 8601 date-time string[7-1]    date-time when video will become available
     */
    public $startsAt;

}