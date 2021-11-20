<?php

namespace App\Services\Guzzle;

class GuzzleService implements GuzzleServiceInterface
{
    public function requestGuzzle($client, $method, $url) {
        try {
            return $client->request($method, $url);
        } catch (RequestException $e) {
            $content = json_decode($e->getResponse()->getBody()->getContents());
            return $content->error->message;
        }
    }
}
