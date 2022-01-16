<?php

namespace App\Repositories\Guzzle;

interface GuzzleRepositoryInterface
{
    public function firstRequest($url);

    public function secondRequest($url);
}
