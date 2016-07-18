<?php

namespace ContemporaryVA\BrightCove\Decorators;
use ContemporaryVA\BrightCove\BrightCoveInterface;
use ContemporaryVA\BrightCove\CMS\Videos;

/**
 * AbstractBrightCoveDecorator
 * Allows extending the BrightCove library functionality
 * @author Ronald Castillo <ronaldcastillo@gmail.com>
 */
abstract class AbstractBrightCoveDecorator extends BrightCoveInterface
{

    /**
     * @var \ContemporaryVA\BrightCove\BrightCove
     */
    protected $brightcove;

    /**
     * @var string
     */
    public $clientId;

    /**
     * @var string
     */
    public $clientSecret;

    /**
     * @var string
     */
    public $accountId;

    /**
     * @param \ContemporaryVA\BrightCove\BrightCove $brightcove
     */
    public function __construct(\ContemporaryVA\BrightCove\BrightCove $brightcove)
    {
        $this->brightcove = $brightcove;

        $this->clientId = $this->brightcove->clientId;
        $this->clientSecret = $this->brightcove->clientSecret;
        $this->accountId = $this->brightcove->accountId;
    }

    public function authenticate()
    {
        return $this->brightcove->authenticate();
    }

    /**
     * @return \ContemporaryVA\BrightCove\CMS\Videos
     */
    public function videos()
    {
        return new Videos($this);
    }

    /**
     * @return \ContemporaryVA\BrightCove\DynamicIngest\DynamicIngest
     */
    public function ingest()
    {
        return $this->brightcove->ingest();
    }

    /**
     * @return \ContemporaryVA\BrightCove\CMS\Videos
     */
    public function analytics()
    {
        return $this->brightcove->analytics();
    }

    /**
     * @return \ContemporaryVA\BrightCove\CMS\Playlists
     */
    public function playlists()
    {
        return $this->brightcove->playlists();
    }

    /**
     * @return \ContemporaryVA\BrightCove\CMS\Subscriptions
     */
    public function subscriptions()
    {
        return $this->brightcove->subscriptions();
    }

    /**
     * @return \ContemporaryVA\BrightCove\Common
     */
    public function common()
    {
        return $this->brightcove->common();
    }

}