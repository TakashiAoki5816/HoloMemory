<?php

namespace App\Repositories\Guzzle;

use App\Repositories\Guzzle\GuzzleRepositoryInterface;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Exception\ClientException;

class GuzzleRepository implements GuzzleRepositoryInterface
{
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function firstRequest($method, $url)
    {
        try {
            return $this->client->request($method, $url);
        } catch (ClientException $e) {
            return $e;
        } catch (RequestException $e) {
            return $e;
        }
    }

    public function secondRequest($method, $url) {
        try {
            return $this->client->request($method, $url);
        } catch (ClientException $e) {
            //もう一つのAPIキーも使用できない場合
            return redirect('/')->with('status', $e->getMessage());
        } catch (RequestException $e) {
            //もう一つのAPIキーも使用できない場合
            return redirect('/')->with('status', $e->getMessage());
        }
    }

}
