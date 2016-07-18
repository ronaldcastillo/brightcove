<?php

namespace ContemporaryVA\BrightCove\Entities;

use Carbon\Carbon;
use Illuminate\Support\Collection;

/**
 * Class VideoEntity
 * @package ContemporaryVA\BrightCove\Entities
 */
class VideoEntity extends AbstractEntity
{

    /**
     * @var $id    string    the video id
     * read-only
     */
    public $id;
    /**
     * @var $accountId    string    the id of the account
     * read-only
     */
    public $accountId;
    /**
     * @var $complete    boolean    whether all processing of renditions and images is complete
     * read-only
     */
    public $complete;
    /**
     * @var $createdAt    ISO 8601 date-time string    date-time video was added to the account
     * example: "2014-12-09T06:07:11.877Z"
     * read-only
     */
    public $createdAt;
    /**
     * @var $cuePoints    array of cue_point objects    markers for midroll ad requests or some other action to be
     *      created via the player API
     */
    public $cuePoints;
    /**
     * @var    $customFields object    map of custom field name:value pairs; only fields that have values are included
     */
    public $customFields;
    /**
     * @var $description    string    the short description of the video - 250 single-byte characters maximum
     */
    public $description;
    /**
     * @var $duration    number    length of the video in milliseconds
     * read-only
     */
    public $duration;
    /**
     * @var $economics    string    indicates whether ad requests are permitted for the video
     */
    public $economics;
    /**
     * @var $geo    geo object    if geo-restriction is enabled for the account[1-3], this object will contain
     *      geo-restriction properties for the video
     */
    public $geo;
    /**
     * @var $images    map of image objects[1-4]
     */
    public $images;
    /**
     * @var $link    link object    a related link
     */
    public $link;
    /**
     * @var $longDescription    string    5000 single-byte characters maximum
     */
    public $longDescription;
    /**
     * @var $name    string    video title - required field (256 single-byte characters maximum)
     */
    public $name;
    /**
     * @var $referenceId    string    any value that is unique within the account (150 single-byte characters maximum)
     */
    public $referenceId;
    /**
     * @var $schedule    schedule object    When video becomes available/unavailable[1-1]
     */
    public $schedule;
    /**
     * @var $sharing    sharing object    information about the account the video was shared from or to
     */
    public $sharing;
    /**
     * @var $state    string    current status of the video: ACTIVE | INACTIVE | PENDING | DELETED
     */
    public $state;
    /**
     * @var $tags    array    array of tags (strings) added to the video (128 single-byte characters per tag maximum)
     */
    public $tags;
    /**
     * @var $textTracks    array of text_track objects    data for WebVTT captions associated with the video
     */
    public $textTracks;
    /**
     * @var $updatedAt    ISO 8601 date-time string    date-time video was last modified
     * example: "2015-01-13T17:45:21.977Z"
     * read-only
     */
    public $updatedAt;

    public $digitalMasterId;

    public $folderId;

    public $originalFilename;

    /**
     * @var $sources    array of objects
     * readonly
     */
    public $sources;

    /**
     * @var $analytics
     * readonly
     */
    public $analyitcs;

    public $isHot;

    public $notified;

    public $version;

    public function build($parameters)
    {
        parent::build($parameters);

        $this->buildParameterEntity('geo', 'ContemporaryVA\BrightCove\Entities\GeoEntity');
        $this->buildParameterEntity('link', 'ContemporaryVA\BrightCove\Entities\LinkEntity');
        $this->buildParameterEntity('schedule', 'ContemporaryVA\BrightCove\Entities\ScheduleEntity');
        $this->buildParameterEntity('sharing', 'ContemporaryVA\BrightCove\Entities\SharingEntity');
        $this->buildParameterEntityCollection('cuePoints', 'ContemporaryVA\BrightCove\Entities\CuePointEntity');
        $this->buildParameterEntityCollection('images', 'ContemporaryVA\BrightCove\Entities\ImageEntity');
        $this->buildParameterEntityCollection('textTracks', 'ContemporaryVA\BrightCove\Entities\TextTrackEntity');

        $this->updatedAt = Carbon::parse($this->updatedAt);
        $this->createdAt = Carbon::parse($this->createdAt);
    }

    public function addSources(array $sources)
    {
        $this->sources = new Collection();
        foreach ($sources as $source) {
            $this->sources->push(new VideoSourceEntity($source));
        }
    }

    public function addAnalytics($analytics)
    {
        $this->analyitcs = $analytics;
    }

}