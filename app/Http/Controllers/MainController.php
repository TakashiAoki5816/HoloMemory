<?php

namespace App\Http\Controllers;

use GuzzleHttp\Exception\RequestException;
use App\Services\Youtube\SearchListService;

class MainController extends Controller
{
    public function __construct(SearchListService $searchListService)
    {
        $this->searchListService = $searchListService;
    }

    public function main()
    {
        $response = $this->searchListService->requestSearchList();

        //APIを叩けなかった場合はエラーメッセージを表示
        if ($response instanceof View) {
            return view('main/error', ['message' => $response]);
        }

        return view('main/index', ['posts' => $videos]);
    }
}
