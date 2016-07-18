<?php

namespace ContemporaryVA\BrightCove\Entities;

/**
 * Class SharingEntity
 * @package ContemporaryVA\BrightCove\Entities
 */
class SharingEntity extends AbstractEntity
{

    /**
     * @var    $byExternalAcct    boolean    whether the video was shared from another account
     * readonly
     */
    public $byExternalAcct;
    /**
     * @var    $byId    string    id of the account that shared the video - note that this field is populated only for
     *         the shared copy, not for the original video
     * readonly
     */
    public $byId;
    /**
     * @var    $sourceId    string    id of the video in its original account - note that this field is populated only
     *         for the shared copy, not for the original video
     * readonly
     */
    public $sourceId;
    /**
     * @var    $toExternalAcct    boolean    whether the video is shared to another account
     * readonly
     */
    public $toExternalAcct;
    /**
     * @var    $byReference    boolean    whether the video is shared by reference[8-1]
     * readonly
     */
    public $byReference;

}