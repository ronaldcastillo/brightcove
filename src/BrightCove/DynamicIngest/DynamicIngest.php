<?php

namespace ContemporaryVA\BrightCove\DynamicIngest;

use ContemporaryVA\BrightCove\BrightCove;

/**
 * Class DynamicIngest
 *
 * @package ContemporaryVA\BrightCove\DynamicIngest
 */
class DynamicIngest
{

    const BRIGHTCOVE_CMS_VIDEOS_API = 'https://ingest.api.brightcove.com/v1';

    /**
     * @var BrightCove
     */
    private $brightcove;

    /**
     * @var array
     */
    private $data = [];

    public function __construct(BrightCove $brightcove)
    {
        $this->brightcove = $brightcove;

        $this->brightcove->initClient($this->getBaseUrl($brightcove->accountId));
    }

    public function getBaseUrl($accountId)
    {
        return self::BRIGHTCOVE_CMS_VIDEOS_API . "/accounts/$accountId/videos/";
    }

    public function setPosterImage($image)
    {

        list($width, $height) = getimagesize($image);

        $this->data['poster'] = [
            'url' => $image,
            'width' => $width,
            'height' => $height
        ];

        $this->data['capture-images'] = false;

        return $this;
    }

    public function setThumbnail($image)
    {

        list($width, $height) = getimagesize($image);

        $this->data['thumbnail'] = [
            'url' => $image,
            'width' => $width,
            'height' => $height
        ];

        return $this;
    }

    public function setCallbacks(array $callbacks = array())
    {

        $callbacks = array_filter($callbacks, function ($url) {
            return filter_var($url, FILTER_VALIDATE_URL);
        });

        if (!empty($callbacks)) {
            $this->data['callbacks'] = $callbacks;
        }

        return $this;
    }

    public function setUrl($videoUrl)
    {
        $this->data['master']['url'] = str_replace(' ', '%20', stripslashes($videoUrl));

        return $this;
    }

    public function setProfile($profile)
    {
        $this->data['profile'] = $profile;

        return $this;
    }

    public function send($videoId)
    {
        $response = $this->brightcove->client->post("$videoId/ingest-requests", array(
            'json' => $this->data
        ));

        $this->data = [];

        return $response->json();
    }

    /**
     * @param string $videoId
     * @param string $videoUrl
     * @param string $profile
     * @param array $callbacks
     * @param null $image
     * @return mixed
     */
    public function upload($videoId, $videoUrl, $profile = Profile::MP4_ONLY, array $callbacks = array(), $image = null)
    {
        $this
            ->setUrl($videoUrl)
            ->setProfile($profile);

        if ( ! is_null($image)) {
            $this
                ->setPosterImage($image)
                ->setThumbnail($image);
        }

        if (!empty($callbacks)) {
            $this->setCallbacks($callbacks);
        }

        return $this->send($videoId);
    }
}