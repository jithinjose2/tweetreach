<?php

namespace TweetReach;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Tweet extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'url', 'status', 'reach', 'tweet_id'
    ];

    const STATUS_NEW = 0;
    const STATUS_DISPATCHED = 1;
    const STATUS_DONE = 5;
}
