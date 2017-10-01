<?php
namespace TweetReach\Services;

class TwitterService
{

    public function __construct()
    {
        $this->consumerKey = config('services.twitter.consumer_key');
        $this->consumerSecret = config('services.twitter.consumer_key');
    }

}