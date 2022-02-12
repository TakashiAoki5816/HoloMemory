<?php

namespace App\Repositories\Guzzle;

interface GuzzleRepositoryInterface
{
    public function firstRequest(string $url);

    public function secondRequest(string $url);
}
