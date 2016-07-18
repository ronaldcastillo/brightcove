<?php

namespace ContemporaryVA\BrightCove\Analytics;

use ContemporaryVA\BrightCove\ServiceAbstract;

/**
 * Class Analytics
 * @package ContemporaryVA\BrightCove\Analytics
 */
class Analytics extends ServiceAbstract
{

    const BRIGHTCOVE_ANALYTICS_API = "https://analytics.api.brightcove.com/v1/data";

    /**
     * @param string $videoId
     * @return array
     */
    public function getForVideoId($videoId)
    {
        $data = $this->make('get', [$this->getBaseUrl(), [
            'query' => [
                'accounts' => $this->brightcove->accountId,
                'dimensions' => 'video',
                'limit' => 'all',
                'fields' => 'engagement_score,play_rate,video,video_duration,video_engagement_1,video_engagement_100,video_engagement_25,video_engagement_50,video_engagement_75,video_impression,video_name,video_percent_viewed,video_seconds_viewed,video_view,video.reference_id',
                'where' => 'video.q==id:' . $videoId
            ]
        ]], 'analyticsForVideo' . $videoId);

        if (isset($data['items']) && !empty($data['items'])) {
            return $data['items'][0];
        }

        return [];
    }

    /**
     * @param array $options
     * @return array
     */
    public function getReport($options = [])
    {

        $default = [
            'limit' => 30,
            'dimensions' => 'video',
            'sort' => 'video_view',
            'from' => 'alltime',
            'to' => 'now',
            'accounts' => $this->brightcove->accountId
        ];

        $options = array_merge($default, $options);

        $data = $this->make('get', [ $this->getBaseUrl() . '/report', [
            'query' => $options
        ]]);

        if (isset($data['items']) && !empty($data['items'])) {
            return $data['items'];
        }

        return [];
    }

    /**
     * @param string $accountId
     * @return string|void
     */
    public function setBaseUrl($accountId)
    {
        $this->baseUrl = self::BRIGHTCOVE_ANALYTICS_API;
    }
}