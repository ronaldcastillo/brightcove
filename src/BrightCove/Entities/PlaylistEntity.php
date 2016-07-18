<?php

namespace ContemporaryVA\BrightCove\Entities;

use Carbon\Carbon;
use Illuminate\Support\Collection;

/**
 * Class PlaylistEntity
 *
 * @extends AbstractEntity
 * @package ContemporaryVA\BrightCove\Entities
 */
class PlaylistEntity extends AbstractEntity
{

    /**
     * @var    $id    string    the playlist id
     * read-only
     */
    public $id;

    /**
     * @var    $accountId    string    the id of the account
     * read-only
     */
    public $accountId;

    /**
     * @var $createdAt ISO 8601 date-time string    date-time video was added to the account
     * readonly
     * example:
     *      "2014-12-09T06:07:11.877Z"
     */
    public $createdAt;

    /**
     * @var $description string    the short description of the video
     * 128 single-byte characters maximum
     */
    public $description;

    /**
     * @var $favorite boolean    whether the playlist is included in favorites
     */
    public $favorite;

    /**
     * @var $limit number    number of videos the playlist can hold (integer, 1 - 100)
     */
    public $limit;

    /**
     * @var $name string    Playlist title - required field
     */
    public $name;

    /**
     * @var $referenceId string    any value that is unique within the account
     */
    public $referenceId;

    /**
     * @var $search string    search string used to define the videos for a Smart playlist
     * example:
     *      "+tags:\"bird\",\"birds\""
     */
    public $search;

    /**
     * @var $type string    the type of playlist    See note[1] below
     * Notes:
     * [1] The type value can only be one of: EXPLICIT, ACTIVATED_OLDEST_TO_NEWEST, ACTIVATED_NEWEST_TO_OLDEST,
     * ALPHABETICAL, PLAYS_TOTAL, PLAYS_TRAILING_WEEK, START_DATE_OLDEST_TO_NEWEST,START_DATE_NEWEST_TO_OLDEST EXPLICIT
     * means that it is a manual playlist; all the other types are smart playlists with names corresponding to their
     * ordering scheme.
     *
     */
    public $type;

    /**
     * @var $updatedAt ISO 8601 date-time string    date-time playlist was last modified
     * read-only
     * example:
     *      "2015-01-13T17:45:21.977Z"
     */
    public $updatedAt;

    /**
     * @var $videoIds array    array of ids for the videos in the playlist
     * Note that for Smart playlists, the array will be empty, as the list of videos is determined by the search and
     * type fields
     */
    public $videoIds;

    /**
     * @var $videos Collection
     */
    public $videos;

    public function build($parameters)
    {
        parent::build($parameters);

        $this->updatedAt = Carbon::parse($this->updatedAt);
        $this->createdAt = Carbon::parse($this->createdAt);
    }

    public function addVideos(array $videos)
    {
        $this->videos = new Collection();
        foreach ($videos as $video) {
            $this->videos->push(new VideoEntity($video));
        }
    }
}