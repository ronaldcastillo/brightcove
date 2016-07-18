<?php

namespace ContemporaryVA\BrightCove\Entities;

class CuePointEntity extends AbstractEntity
{

    /**
     * @var $id    string    the cue point id
     * readonly
     */
    public $id;
    /**
     * @var $name    string    optional name for the cue point (128 single-byte characters maximum)
     */
    public $name;
    /**
     * @var $type    string    AD or CODE
     */
    public $type;
    /**
     * @var $time    number    time of the cue point in seconds; example: 10.527
     */
    public $time;
    /**
     * @var $metadata    string    optional metadata string (128 single-byte characters maximum)
     */
    public $metadata;
    /**
     * @var $forceStop    boolean    whether video is force-stopped at the cue point
     */
    public $forceStop;

}