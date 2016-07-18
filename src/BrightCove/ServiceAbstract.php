<?php

namespace ContemporaryVA\BrightCove;

/**
 * Class ServiceAbstract
 *
 * @abstract
 * @package ContemporaryVA\BrightCove
 */
abstract class ServiceAbstract
{

    /**
     * @var \GuzzleHttp\Client
     */
    public $client;

    /**
     * @var string
     */
    public $baseUrl;

    /**
     * ServiceAbstract constructor.
     * @param BrightCoveInterface $brightcove
     */
    public function __construct(BrightCoveInterface $brightcove)
    {

        $this->brightcove = $brightcove;

        $this->setBaseUrl($this->brightcove->accountId);

        $this->client = $this->brightcove->initClient($this->getBaseUrl());
    }

    /**
     * @return string
     */
    public function getBaseUrl()
    {
        return $this->baseUrl;
    }

    /**
     * @param $accountId
     * @return string
     */
    public abstract function setBaseUrl($accountId);

    /**
     * @param $method
     * @param $request
     * @param string $stringIdentifier
     * @param int $duration
     * @return mixed
     */
    public function make($method, $request, $stringIdentifier = '', $duration = 30)
    {
        return $this->brightcove->make($this->client, $method, $request, $stringIdentifier, $duration);
    }
}