<?php

namespace ContemporaryVA\BrightCove\CMS;

use App\Events\BrightCove\PlaylistIsBeingFetched;
use App\Events\BrightCove\PlaylistWasFetched;
use ContemporaryVA\BrightCove\Entities\PlaylistEntity;
use ContemporaryVA\BrightCove\ServiceAbstract;

class Playlists extends ServiceAbstract
{

    const BRIGHTCOVE_CMS_VIDEOS_API = 'https://cms.api.brightcove.com/v1';

    public function findAll()
    {
        $playlistsJson = $this->make('get', [$this->getBaseUrl() . '/']);

        dd($playlistsJson);
    }

    public function findById($playlistId)
    {
        $playlist = event(new PlaylistIsBeingFetched($playlistId))[0];

        // if we have a playlist returned from the event response and the playlist is a PlaylistEntity, return.
        if ($playlist instanceof PlaylistEntity) {
            return $playlist;
        }

        $playlist = new PlaylistEntity($this->make('get', [$this->getBaseUrl() . '/' . $playlistId]));
        $playlist->addVideos($this->make('get', [$this->getBaseUrl() . '/' . $playlistId . '/videos']));
        $playlist->videos = $playlist->videos->map(function ($video) {
            return $this->brightcove->videos()->findById($video->id);
        });

        event(new PlaylistWasFetched($playlist));

        return $playlist;
    }

    public function setBaseUrl($accountId)
    {
        $this->baseUrl = self::BRIGHTCOVE_CMS_VIDEOS_API . "/accounts/$accountId/playlists";
    }
}