<?php

namespace TweetReach\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use TweetReach\Services\TwitterService;
use TweetReach\Tweet;

class FetchTweetReach implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tweet;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Tweet $tweet)
    {
        $this->tweet = $tweet;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->twitterService = app(TwitterService::class);
        $ids = $this->twitterService->getRetweeters($this->tweet->tweet_id);
        $followers = $this->twitterService->getFollowersCount($ids);
        $this->tweet->reach = $followers;
        $this->tweet->status = Tweet::STATUS_DONE;
        $this->tweet->save();
    }
}
