<?php

namespace App\Repositories\Guzzle;

use App\Repositories\Guzzle\GuzzleRepositoryInterface;
use GuzzleHttp\Exception\RequestException;

class GuzzleRepository implements GuzzleRepositoryInterface
{
    public function firstRequest($method, $url)
    {
        try {
            return $this->client->request($method, $url);
        } catch (RequestException $e) {
            // $content = json_decode($e->getResponse()->getBody()->getContents());
            // return $content->error->message;
            throw $e;
        }
    }

    public function secondRequest($method, $url) {
        try {
            return $this->client->request($method, $url);
        } catch (RequestException $e) {
            //もう一つのAPIキーも使用できない場合
            return redirect('/')->with('status', $e->getMessage());
        }
    }

}
