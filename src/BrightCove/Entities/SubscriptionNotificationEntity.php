<?php

namespace ContemporaryVA\BrightCove\Entities;

/**
 * Class SubscriptionNotificationEntity
 * @package ContemporaryVA\BrightCove\Entities
 */
class SubscriptionNotificationEntity extends AbstractEntity
{

    public $timestamp;

    public $accountId;

    public $event;

    public $video;

    public $version;

}