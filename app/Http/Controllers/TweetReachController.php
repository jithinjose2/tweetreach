<?php
namespace TweetReach\Http\Controllers;

use Illuminate\Http\Request;
use TweetReach\Repositories\TweetReachRepository;
use TweetReach\Rules\TweetUrl;
use TweetReach\Services\TwitterService;

class TweetReachController extends Controller
{

    public function __construct(TweetReachRepository $tweetRepo)
    {
        $this->tweetRepo = $tweetRepo;
    }

    public function show()
    {
        return view('home');
    }

    public function getReach(Request $request)
    {
        $request->validate([
            'tweet_url' => ['required', app(TweetUrl::class)]
        ]);

        $tweet = $this->tweetRepo->getTweetReach($request->get('tweet_url'));

        return ['tweet' => $tweet->toArray()];
    }
}
