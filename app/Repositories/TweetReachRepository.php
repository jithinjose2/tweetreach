<?php
namespace TweetReach\Repositories;

use Carbon\Carbon;
use TweetReach\Jobs\FetchTweetReach;
use TweetReach\Services\TwitterService;
use TweetReach\Tweet;

class TweetReachRepository
{
    public function __construct(TwitterService $twitterService)
    {
        $this->twitterService = $twitterService;
    }

    public function getTweetReach($tweetUrl) : Tweet
    {
        $tweetId = $this->twitterService->extractTweetID($tweetUrl);

        $tweet = Tweet::firstOrNew([
            'tweet_id' => $tweetId
        ],[
            'status' => Tweet::STATUS_NEW
        ]);
        $tweet->save();

        if ($tweet->status==Tweet::STATUS_NEW || $tweet->updated_at->diffInMinutes(Carbon::now())>120) {
            $tweet->status = Tweet::STATUS_DISPATCHED;
            dispatch(new FetchTweetReach($tweet));
        }

        $tweet->save();

        return $tweet;
    }
}