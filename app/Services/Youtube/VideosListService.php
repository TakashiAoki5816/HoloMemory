<?php

namespace App\Services\Youtube;

use App\Repositories\Guzzle\GuzzleRepositoryInterface;
use DateTime;
use DateTimeZone;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\RequestException;

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
    public function checkDiffToday(string $videoId): string
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
    public function getScheduledStartTime(string $videoId): object
    {
        $url = $this->setUrl($videoId);

        $clientResponse = $this->clientInterface->firstRequest($url);
        if ($clientResponse instanceof ClientException || $clientResponse instanceof RequestException) {
            //メインのAPIキーが使えなかった場合、別プロジェクトのAPIキーを使用
            $url = $this->subSetUrl($videoId);
            $clientResponse = $this->clientInterface->secondRequest($url);
        }

        $body = $clientResponse->getBody();
        $video = json_decode($body, true);

        $date = $video["items"][0]["liveStreamingDetails"]["scheduledStartTime"];
        $dateTime = new DateTime($date);
        $scheduleStartTime = $dateTime->setTimezone(new DateTimeZone('Asia/Tokyo'));

        return $scheduleStartTime;
    }

    /**
     * 開始日時と本日の日付の差を取得
     *
     * @param DateTime $scheduleStartTime
     * @return string
     */
    public function getStartTimeDiffToday(DateTime $scheduleStartTime): string
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
    public function setUrl(string $videoId): string
    {
        return "https://www.googleapis.com/youtube/v3/videos?part=liveStreamingDetails&id=" . $videoId . "&key=" . config('app.API_KEY');
    }

    /**
     * サブAPIキーを使用
     *
     * @param string $videoId
     * @return string
     */
    public function subSetUrl(string $videoId): string
    {
        return "https://www.googleapis.com/youtube/v3/videos?part=liveStreamingDetails&id=" . $videoId . "&key=" . config('app.SUB_API_KEY');
    }
}
