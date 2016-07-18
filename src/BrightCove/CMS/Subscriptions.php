<?php

namespace ContemporaryVA\BrightCove\CMS;

use ContemporaryVA\BrightCove\Entities\SubscriptionEntity;
use ContemporaryVA\BrightCove\ServiceAbstract;
use GuzzleHttp\Message\Response;
use Illuminate\Support\Collection;

class Subscriptions extends ServiceAbstract
{

    const BRIGHTCOVE_CMS_VIDEOS_API = 'https://cms.api.brightcove.com/v1';

    public function findAll()
    {
        $allSubscriptions = $this->make('get', [$this->getBaseUrl()], 'allSubscriptions' . time());

        $subscriptions = new Collection();
        if (!empty($allSubscriptions)) {
            foreach ($allSubscriptions as $subscription) {
                $subscriptions->push(new SubscriptionEntity($subscription));
            }
        }

        return $subscriptions;
    }

    public function findById($subscriptionId)
    {
        return new SubscriptionEntity($this->make('get', [$this->getbaseUrl() . '/' . $subscriptionId], 'subscriptionId' . $subscriptionId . time()));
    }

    public function create($endpoint)
    {
        $subscription = $this->make('post', [$this->getBaseUrl(), [
            'json' => [
                'endpoint' => $endpoint,
                'events' => [
                    'video-change'
                ]
            ]
        ]]);

        return new SubscriptionEntity($subscription->json());
    }

    public function delete($subscriptionId)
    {
        /** @var Response $response */
        $response = $this->make('delete', [$this->getBaseUrl() . '/' . $subscriptionId]);
        if ($response->getStatusCode() === 204) {
            return true;
        }
        return false;
    }

    public function setBaseUrl($accountId)
    {
        $this->baseUrl = self::BRIGHTCOVE_CMS_VIDEOS_API . "/accounts/$accountId/subscriptions";
    }
}