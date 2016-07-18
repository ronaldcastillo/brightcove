<?php

namespace ContemporaryVA\BrightCove;

use GuzzleHttp\Client;
use ContemporaryVA\BrightCove\Analytics\Analytics;
use ContemporaryVA\BrightCove\CMS\Playlists;
use ContemporaryVA\BrightCove\CMS\Subscriptions;
use ContemporaryVA\BrightCove\CMS\Videos;
use ContemporaryVA\BrightCove\DynamicIngest\DynamicIngest;

/**
 * Class BrightCove
 *
 * @package ContemporaryVA\BrightCove
 */
class BrightCove extends BrightCoveInterface
{

    const BRIGHTCOVE_AUTHENTICATION_URL = 'https://oauth.brightcove.com/v3/access_token';

    const BRIGHTCOVE_CLIENT_CREDENTIALS_URL = 'https://oauth.brightcove.com/v3/client_credentials';

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
    public function videos()
    {
        return new Videos($this);
    }

    /**
     * @return DynamicIngest
     */
    public function ingest()
    {
        return new DynamicIngest($this);
    }

    /**
     * @return Analytics
     */
    public function analytics()
    {
        return new Analytics($this);
    }

    /**
     * @return Playlists
     */
    public function playlists()
    {
        return new Playlists($this);
    }

    /**
     * @return Subscriptions
     */
    public function subscriptions()
    {
        return new Subscriptions($this);
    }

    /**
     * @return Common
     */
    public function common()
    {
        return new Common($this);
    }

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

    public function authenticate()
    {

        var_dump('Called the authentication');

        $client = new Client();

        $response = $client->post(self::BRIGHTCOVE_AUTHENTICATION_URL, array(
            'headers' => array(
                'Authorization' => 'Basic ' . base64_encode("{$this->clientId}:{$this->clientSecret}")
            ),
            'body' => array(
                'grant_type' => 'client_credentials'
            ),
            'verify' => false
        ));

        $result = $response->json();

        return $result['access_token'];
    }
}