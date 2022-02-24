<?php

namespace App\Repositories\Guzzle;

use App\Consts\GuzzleRepositoryConsts;
use App\Exceptions\RedirectExceptions;
use App\Repositories\Guzzle\GuzzleRepositoryInterface;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Exception\ClientException;

class GuzzleRepository implements GuzzleRepositoryInterface
{
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * 1つ目のAPIキーによるリクエスト
     *
     * @param string $url
     * @return Response
     * @return Exception $e
     */
    public function firstRequest($url)
    {
        try {
            return $this->client->request(GuzzleRepositoryConsts::GET_METHOD, $url);
        } catch (ClientException $e) {
            return $e;
        }
    }

    /**
     * 2つ目のAPIキーによるリクエスト
     *
     * @param string $url
     * @return Response
     * @throws RedirectExceptions
     */
    public function secondRequest($url)
    {
        try {
            return $this->client->request(GuzzleRepositoryConsts::GET_METHOD, $url);
        } catch (ClientException $e) {
            throw new RedirectExceptions(route('root'), "1日のクォータ使用量を超えているため、リクエストを完了できません。", $e->getCode());
        }
    }
}
