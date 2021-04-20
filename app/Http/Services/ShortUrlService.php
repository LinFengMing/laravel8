<?php

namespace App\Http\Services;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class ShortUrlService implements ShortUrlInterfaceService
{
    protected $client;

    public $version = 2.5;

    public function __construct()
    {
        $this->client = new Client();
    }

    public function makeShortUrl($url)
    {
        try {
            $accessToken = env('URL_ACCESS_Token');
            $data = [
                'url' => $url
            ];

            Log::channel('url_shorten')->info('postData', ['data' => $data]);

            $response = $this->client->request(
                'POST',
                "http://api.pics.ee/v1/links/?access_token=$accessToken",
                [
                    'headers' => ['Content-Type' => 'application/json'],
                    'body' => json_encode($data)
                ]
            );

            $contents = $response->getBody()->getContents();

            Log::channel('url_shorten')->info('responseData', ['data' => $contents]);

            $contents = json_decode($contents);
        } catch (\Throwable $th) {
            report($th);

            return $url;
        }

        return $contents->data->picseeUrl;
    }
}
