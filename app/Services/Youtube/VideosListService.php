<?php

namespace App\Services\Youtube;

use App\Repositories\Guzzle\GuzzleRepositoryInterface;
use DateTime;

class VideosListService
{
    /**
     * @param GuzzleRepositoryInterface $clientInterface
     */
    public function __construct(GuzzleRepositoryInterface $clientInterface)
    {
        $this->clientInterface = $clientInterface;
    }

    /**
     * 今日の日付との差を確認
     *
     * @param string $videoId
     * @return string
     */
    public function checkDiffToday($videoId)
    {
        $scheduleStartTime = $this->getScheduledStartTime($videoId);

        return $this->getStartTimeDiffToday($scheduleStartTime);
    }

    /**
     * 配信開始日時を取得
     *
     * @param string $videoId
     * @return DateTime $scheduleStartTime
     */
    public function getScheduledStartTime($videoId)
    {
        $method = "GET";
        $url = $this->setUrl($videoId);
        // $url = $this->subSetUrl($videoId);

        $response = $this->clientInterface->firstRequest($method, $url);

        if ($response instanceof ClientException || $response instanceof RequestException) {
            //メインのAPIキーが使えなかった場合、別プロジェクトのAPIキーを使用
            $url = $this->subSetUrl($videoId);
            $response = $this->clientInterface->secondRequest($method, $url);
        }

        $body = $response->getBody();
        $video = json_decode($body, true);

        $date = $video["items"][0]["liveStreamingDetails"]["scheduledStartTime"];
        $scheduleStartTime = new DateTime($date);

        return $scheduleStartTime;
    }

    /**
     * 開始日時と本日の日付の差を取得
     *
     * @param DateTime $scheduleStartTime
     * @return string
     */
    public function getStartTimeDiffToday($scheduleStartTime)
    {
        $now = new DateTime('now');
        $interval = $now->diff($scheduleStartTime);

        return $interval->format('%a');
    }

    /**
     * メインAPIキーを使用
     *
     * @param string $videoId
     * @return string
     */
    public function setUrl($videoId)
    {
        return "https://www.googleapis.com/youtube/v3/videos?part=liveStreamingDetails&id=" . $videoId . "&key=" . config('app.API_KEY');
    }

    /**
     * サブAPIキーを使用
     *
     * @param string $videoId
     * @return string
     */
    public function subSetUrl($videoId)
    {
        return "https://www.googleapis.com/youtube/v3/videos?part=liveStreamingDetails&id=" . $videoId . "&key=" . config('app.SUB_API_KEY');
    }
}
