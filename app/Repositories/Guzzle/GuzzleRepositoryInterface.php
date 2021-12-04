<?php

namespace App\Repositories\Guzzle;

interface GuzzleRepositoryInterface
{
    public function firstRequest($method, $url);

    public function secondRequest($method, $url);
}
