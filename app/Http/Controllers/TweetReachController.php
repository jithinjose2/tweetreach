<?php

namespace TweetReach\Http\Controllers;

use Illuminate\Http\Request;
use TweetReach\Services\TwitterService;

class TweetReachController extends Controller
{

    public function __construct(TwitterService $twitterService)
    {
        $this->twitterService = $twitterService;
    }

    public function tweetReach()
    {
        dd($this->twitterService->getAccessToken());
    }
}
