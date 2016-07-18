<?php

namespace ContemporaryVA\BrightCove\Entities;

use Carbon\Carbon;

/**
 * Class VideoSourceEntity
 * @package ContemporaryVA\BrightCove\Entities
 */
class VideoSourceEntity extends AbstractEntity
{

    /**
     * @var
     */
    public $assetId;

    /**
     * @var
     */
    public $appName;

    /**
     * @var
     */
    public $streamName;

    /**
     * @var
     */
    public $src;

    /**
     * @var
     */
    public $codec;

    /**
     * @var
     */
    public $container;

    /**
     * @var
     */
    public $encodingRate;

    /**
     * @var
     */
    public $duration;

    /**
     * @var
     */
    public $height;

    /**
     * @var
     */
    public $width;

    /**
     * @var
     */
    public $size;

    /**
     * @var
     */
    public $uploadedAt;

    /**
     * @var
     */
    public $remote;

    public function build($parameters)
    {
        parent::build($parameters);

        $this->uploadedAt = Carbon::parse($this->uploadedAt);
    }
}