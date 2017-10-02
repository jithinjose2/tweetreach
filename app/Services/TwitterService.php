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
        if (empty($this->accessToken)) {
            $response = $this->client->post('oauth2/token', [
                'form_params' => [
                    'grant_type' => 'client_credentials'
                ],
                'headers' => [
                    'Authorization' => 'Basic ' . base64_encode($this->consumerKey . ':' . $this->consumerSecret) . '=='
                ]
            ]);

            $content = $response->getBody()->getContents();
            $content = json_decode($content);

            $this->accessToken = $content->access_token;
        }

        return $this->accessToken;
    }

    public function getRetweeters($tweetID)
    {
        $response = $this->client->get('1.1/statuses/retweeters/ids.json', [
            'query' => [
                'id' => $tweetID,
                'stringify_ids' => false
            ],
            'headers' => [
                'Authorization' => 'Bearer ' . $this->getAccessToken()
            ]
        ]);

        $data = $response->getBody()->getContents();
        $data = json_decode($data);
        return $data->ids;
    }

    public function getFollowersCount($userIDs)
    {
        $response = $this->client->get('1.1/users/lookup.json', [
            'query' => [
                'user_id' => implode(',', $userIDs)
            ],
            'headers' => [
                'Authorization' => 'Bearer ' . $this->getAccessToken()
            ]
        ]);

        $data = $response->getBody()->getContents();
        $data = json_decode($data, true);
        return array_sum(array_column($data,'followers_count'));
    }

    public function extractTweetID($tweetURL)
    {
        $tweetURL = str_replace('https://twitter.com/', '', $tweetURL);
        $tweetURL = explode('/', $tweetURL);

        if (!empty($tweetURL[2])) {
            return $tweetURL[2];
        }
        return false;
    }

}