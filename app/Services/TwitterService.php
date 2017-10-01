<?php
namespace TweetReach\Services;

use GuzzleHttp\Client;

class TwitterService
{

    private $accessToken;

    public function __construct()
    {
        $this->consumerKey = config('services.twitter.consumer_key');
        $this->consumerSecret = config('services.twitter.consumer_secret');
        $this->client = new Client([
            'base_uri' => 'https://api.twitter.com/',
        ]);
    }

    public function getAccessToken()
    {
        $response = $this->client->post('oauth2/token', [
            'form_params' => [
                'grant_type' => 'client_credentials'
            ],
            'headers' => [
               'Authorization' => 'Basic ' . base64_encode($this->consumerKey . ':' . $this->consumerSecret).'=='
            ]
        ]);

        $content = $response->getBody()->getContents();
        $content = json_decode($content);

        $this->accessToken = $content->access_token;
    }

}