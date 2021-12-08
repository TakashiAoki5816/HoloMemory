<?php

namespace App\Services\Youtube;

use App\Repositories\Guzzle\GuzzleRepositoryInterface;
use DateTime;

class VideosListService
{
    public function __construct(GuzzleRepositoryInterface $clientInterface)
    {
        $this->clientInterface = $clientInterface;
    }

    public function getScheduledStartTime($videoId)
    {
        $method = "GET";

        $url = $this->setUrl($videoId);
        $response = $this->clientInterface->firstRequest($method, $url);

        if ($response instanceof RequestException) {
            //メインのAPIキーが使えなかった場合、別プロジェクトのAPIキーを使用
            $url = $this->subSetUrl($videoId);
            $response = $this->clientInterface->secondRequest($method, $url);
        }

        $body = $response->getBody();
        $video = json_decode($body, true);

        $date = $video["items"][0]["liveStreamingDetails"]["scheduledStartTime"];
        $scheduleStartTime = new DateTime($date);

        return $scheduleStartTime->format('Y-m-d');
    }

    public function setUrl($videoId)
    {
        return "https://www.googleapis.com/youtube/v3/videos?part=liveStreamingDetails&id=" . $videoId . "&key=" . config('app.API_KEY');
    }

    public function subSetUrl($videoId)
    {
        return "https://www.googleapis.com/youtube/v3/videos?part=liveStreamingDetails&id=" . $videoId . "&key=" . config('app.SUB_API_KEY');
    }
}
