<?php

namespace TweetReach\Rules;

use Illuminate\Contracts\Validation\Rule;
use TweetReach\Services\TwitterService;

class TweetUrl implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct(TwitterService $tweetService)
    {
        $this->tweetService = $tweetService;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return $this->tweetService->extractTweetID($value) !== false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Invalid Tweet URL.';
    }
}
