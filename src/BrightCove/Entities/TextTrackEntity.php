<?php

namespace ContemporaryVA\BrightCove\Entities;

/**
 * Class TextTrackEntity
 * @package ContemporaryVA\BrightCove\Entities
 */
class TextTrackEntity extends AbstractEntity
{

    /**
     * @var $src    string (URL)    URL where the .vtt file resides
     */
    public $src;
    /**
     * @var $srclang    ISO-639-1 language code    language for the captions
     */
    public $srclang;
    /**
     * @var $label    string    The label to be used in the player menu - it should be in the same language as the
     *      captions
     */
    public $label;
    /**
     * @var $kind    string    "captions" is the only value currently supported
     */
    public $kind;
    /**
     * @var $mimeType    strings    The mime-type of the captions[9-1]
     */
    public $mimeType;
    /**
     * @var $default    boolean    Setting this to true makes this the default captions file in the player menu
     */
    public $default;

}