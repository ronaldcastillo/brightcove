<?php

namespace ContemporaryVA\BrightCove;

use ContemporaryVA\BrightCove\Entities\VideoEntity;

/**
 * Class Common
 *
 * @package ContemporaryVA\BrightCove
 */
class Common
{

    /**
     * @var BrightCove
     */
    protected $brightcove;

    /**
     * @param BrightCove $brightcove
     */
    public function __construct(BrightCove $brightcove)
    {
        $this->brightcove = $brightcove;
    }

    /**
     * @param int $count
     * @param int $offset
     *
     * @return \Illuminate\Support\Collection
     */
    public function getRecentVideos($offset = 0, $count = 16)
    {
        return $this->brightcove->videos()->findAll($count, $offset);
    }

    /**
     * @param $videoId
     *
     * @return Entities\VideoEntity
     */
    public function getVideo($videoId)
    {
        return $this->brightcove->videos()->findById($videoId);
    }

    /**
     * @param     $query
     * @param int $count
     * @param int $offset
     *
     * @return \Illuminate\Support\Collection
     */
    public function getVideosByQuery($query, $count = 16, $offset = 0)
    {
        return $this->brightcove->videos()->findAll($count, $offset, "-created_at", $query);
    }

}