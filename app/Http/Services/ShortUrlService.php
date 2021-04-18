<?php

namespace App\Http\Services;

use GuzzleHttp\Client;

class ShortUrlService
{
    protected $client;

    public function __construct()
    {
        $this->client = new Client();
    }

    public function makeShortUrl($url)
    {
        $accessToken = env('URL_ACCESS_Token');
        $data = [
            'url' => $url
        ];

        $response = $this->client->request(
            'POST',
            "http://api.pics.ee/v1/links/?access_token=$accessToken",
            [
                'headers' => ['Content-Type' => 'application/json'],
                'body' => json_encode($data)
            ]
        );

        $contents = $response->getBody()->getContents();
        $contents = json_decode($contents);

        return $contents->data->picseeUrl;
    }
}
