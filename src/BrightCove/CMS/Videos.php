<?php namespace ContemporaryVA\BrightCove\CMS;

use App\Events\BrightCove\VideoIsBeingFetched;
use App\Events\BrightCove\VideoListIsBeingFetched;
use App\Events\BrightCove\VideoListWasFetched;
use App\Events\BrightCove\VideoWasFetched;
use ContemporaryVA\BrightCove\Entities\VideoEntity;
use ContemporaryVA\BrightCove\ServiceAbstract;
use App\Models\Media;
use Cache;
use Carbon\Carbon;
use Hash;
use Illuminate\Support\Collection;

/**
 * Class Videos
 *
 * @package BrightCove\CMS
 */
class Videos extends ServiceAbstract
{

    const BRIGHTCOVE_CMS_VIDEOS_API = 'https://cms.api.brightcove.com/v1';

    public function findById($videoId, $forceFetch = false)
    {
        if (false === $forceFetch) {
            $video = event(new VideoIsBeingFetched($videoId))[0];

            // if we have a video returned from the event response and the video is a VideoEntity, we can return
            if ($video instanceof VideoEntity) {
                return $video;
            }
        }

        $video = new VideoEntity($this->fetchVideoObject($videoId));

        // if there are no video images for this video... skip
        if (!isset($video->images) || empty($video->images) || $video->images->isEmpty()) {
            return false;
        }

        $video->addSources($this->fetchVideoSources($videoId));

        // if there are no video sources for this video... skip
        if (!isset($video->sources) || empty($video->sources) || $video->sources->isEmpty()) {
            return false;
        }

        // $video->addAnalytics($this->fetchVideoAnalytics($videoId));

        // event(new VideoWasFetched($video));

        return $video;
    }

    /**
     * @param int $limit
     * @param int $offset
     * @param null $sortBy
     * @param string $query
     *
     * @return Collection
     */
    public function findAll($limit = 10, $offset = 0, $sortBy = '-created_at', $query = "")
    {
        $parameters = [
            'limit' => $limit,
            'offset' => $offset
        ];

        // ensure the sort value is not null
        // ensure the sort value is valid
        if (
            !is_null($sortBy)
            &&
            // ensure the sort value is valid
            in_array(str_replace('-', '', $sortBy), [
                'name',
                'reference_id',
                'created_at',
                'published_at',
                'updated_at',
                'schedule_starts_at',
                'schedule_ends_at',
                'state',
                'plays_total',
                'plays_trailing_week'
            ])
        ) {
            $parameters['sort'] = $sortBy;
        }

        // ensure the query is not empty
        if (!empty($query)) {
            // Note: we're limiting searches to the name field
            $parameters['q'] = 'name:' . $query;
        }

        $videoClass = $this;
        $search = Cache::remember(
            'brightcove_recent_list.' . md5(serialize($parameters)),
            Carbon::now()->addMinutes(30)->diffInMinutes(),
            function () use ($videoClass, $parameters) {
                return $videoClass->make(
                    'get',
                    [
                        $videoClass->getBaseUrl() . '/',
                        [
                            'query' => $parameters
                        ]
                    ],
                    http_build_query($parameters)
                );
            }
        );

        $videos = new Collection();

        if (!empty($search)) {
            foreach ($search as $result) {
                if ($video = $this->findById($result['id'])) {
                    $videos->push($video);
                }
            }
        }

        return $videos;
    }

    /**
     * @param array $attributes
     *
     * @return mixed
     */
    public function create($attributes = array())
    {
        $response = $this->make('post', [
            $this->getBaseUrl() . '/',
            array(
                'json' => $attributes
            )
        ]);

        return $response->json();
    }

    /**
     * @param string $videoId
     * @param array $attributes
     *
     * @return mixed
     */
    public function update($videoId, $attributes = array())
    {
        $response = $this->make('patch', [
            $this->getBaseUrl() . '/' . $videoId,
            array(
                'json' => $attributes
            )
        ]);

        return $response->json();
    }

    /**
     * @param string $videoId
     *
     * @return mixed
     */
    public function delete($videoId)
    {
        $response = $this->make('delete', [$this->getBaseUrl() . '/' . $videoId]);

        return $response->json();
    }

    public function setBaseUrl($accountId)
    {
        $this->baseUrl = self::BRIGHTCOVE_CMS_VIDEOS_API . "/accounts/$accountId/videos";
    }

    /**
     * @param $videoId
     *
     * @return mixed
     */
    protected function fetchVideoObject($videoId)
    {
        return $this->make('get', [$this->getBaseUrl() . '/' . $videoId]);
    }

    /**
     * @param $videoId
     *
     * @return mixed
     */
    protected function fetchVideoSources($videoId)
    {
        return $this->make('get', [$this->getBaseUrl() . '/' . $videoId . '/sources']);
    }

    /**
     * @param $videoId
     *
     * @return mixed
     */
    protected function fetchVideoAnalytics($videoId)
    {
        return $this->brightcove->analytics()->getForVideoId($videoId);
    }
}