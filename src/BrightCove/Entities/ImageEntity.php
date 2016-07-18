<?php

namespace ContemporaryVA\BrightCove\Entities;

class ImageEntity extends AbstractEntity
{

    /**
     * @var $assetId    string    System-generated id for the image
     * readonly
     */
    public $assetId;
    /**
     * @var $src    string    URL for image
     * readonly
     */
    public $src;

    public $remote;

    public $sources;

}