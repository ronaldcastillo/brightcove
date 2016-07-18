<?php

namespace ContemporaryVA\BrightCove;
use GuzzleHttp\Client;

/**
 * Class BrightCove
 *
 * @package ContemporaryVA\BrightCove
 */
abstract class BrightCoveInterface
{

    /**
     * @var Client
     */
    public $client;

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
     * @param null $clientId
     * @param null $clientSecret
     * @param null $accountId
     */
    public function __construct($clientId = null, $clientSecret = null, $accountId = null)
    {
        $this->clientId = $clientId;
        $this->clientSecret = $clientSecret;
        $this->accountId = $accountId;
    }

    /**
     * @param string $clientId
     * @return $this
     */
    public function setClientId($clientId)
    {
        $this->clientId = $clientId;
        return $this;
    }

    /**
     * @param string $clientSecret
     * @return $this
     */
    public function setClientSecret($clientSecret)
    {
        $this->clientSecret = $clientSecret;
        return $this;
    }

    /**
     * @param string $accountId
     * @return $this
     */
    public function setAccountId($accountId)
    {
        $this->accountId = $accountId;
        return $this;
    }

    /**
     * @return Videos
     */
    abstract public function videos();

    /**
     * @return DynamicIngest
     */
    abstract public function ingest();

    /**
     * @return Analytics
     */
    abstract public function analytics();

    /**
     * @return Playlists
     */
    abstract public function playlists();

    /**
     * @return Subscriptions
     */
    abstract public function subscriptions();

    /**
     * @return Common
     */
    abstract public function common();

    /**
     * @param Client $client the guzzle client
     * @param        $method        the guzzle method action to call
     * @param array $request an array of parameters to be passed through to guzzle
     * @param string $uniqueString A unique string to better identify get requests
     * @param int $duration Duration in minutes for the data to be cached
     *
     * @return mixed
     */
    public function make(Client $client, $method, array $request, $uniqueString = "unique", $duration = 30)
    {
        switch ($method) {

            case "get":

                $response = call_user_func_array(array($client, $method), $request);

                if ($response->getStatusCode() !== 404) {
                    return $response->json();
                }

                break;

            default:
                return call_user_func_array(array($client, $method), $request);
                break;
        }
    }

    public function initClient($baseUrl)
    {
        return new Client(array(
            'base_url' => $baseUrl,
            'defaults' => array(
                'headers' => array(
                    'Authorization' => 'Bearer ' . $this->authenticate()
                ),
                'verify' => false
            )
        ));
    }

    abstract public function authenticate();
}