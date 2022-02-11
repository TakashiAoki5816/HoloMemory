<?php

namespace App\Repositories\Guzzle;

use App\Consts\GuzzleRepositoryConsts;
use App\Exceptions\RedirectExceptions;
use App\Repositories\Guzzle\GuzzleRepositoryInterface;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\RequestException;

class GuzzleRepository implements GuzzleRepositoryInterface
{
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function firstRequest($url)
    {
        try {
            return $this->client->request(GuzzleRepositoryConsts::GET_METHOD, $url);
        } catch (ClientException $e) {
            return $e;
        } catch (RequestException $e) {
            return $e;
        }
    }

    public function secondRequest($url) {
        try {
            return $this->client->request(GuzzleRepositoryConsts::GET_METHOD, $url);
        } catch (ClientException $e) {
            //もう一つのAPIキーも使用できない場合
            throw new RedirectExceptions(route('index'), $e->getMessage(), $e->getCode());
        } catch (RequestException $e) {
            //もう一つのAPIキーも使用できない場合
            throw new RedirectExceptions(route('index'), $e->getMessage(), $e->getCode());
        }
    }

}
