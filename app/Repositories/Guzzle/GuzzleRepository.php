<?php

namespace App\Repositories\Guzzle;

use App\Consts\GuzzleRepositoryConsts;
use App\Exceptions\RedirectExceptions;
use App\Repositories\Guzzle\GuzzleRepositoryInterface;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use Illuminate\Support\Facades\Log;

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
     */
    public function firstRequest(string $url)
    {
        try {
            return $this->client->request(GuzzleRepositoryConsts::GET_METHOD, $url);
        } catch (Exception $e) {
            if (!config('app.SUB_API_KEY')) {
                Log::debug("エラー内容:" . $e->getMessage() . PHP_EOL . "ファイル名:" . $e->getFile() . PHP_EOL . "エラー行:" . $e->getLine());
                throw new RedirectExceptions(route('root'), "1日のクォータ使用量を超えているため、リクエストを完了できません。", $e->getCode());
            }

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
    public function secondRequest(string $url)
    {
        try {
            return $this->client->request(GuzzleRepositoryConsts::GET_METHOD, $url);
        } catch (Exception $e) {
            Log::debug("エラー内容:" . $e->getMessage() . PHP_EOL . "ファイル名:" . $e->getFile() . PHP_EOL . "エラー行:" . $e->getLine());
            throw new RedirectExceptions(route('root'), "1日のクォータ使用量を超えているため、リクエストを完了できません。", $e->getCode());
        }
    }
}
