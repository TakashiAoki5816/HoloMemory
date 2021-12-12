<?php

namespace App\Services\Youtube;

use App\Models\Member;
use App\Repositories\Guzzle\GuzzleRepositoryInterface;
use App\Services\Youtube\VideosListService;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\RequestException;

class SearchListService
{
    protected $clientInterface;

    /**
     * @param GuzzleRepositoryInterface $clientInterface
     */
    public function __construct(Member $member, GuzzleRepositoryInterface $clientInterface, VideosListService $videosListService)
    {
        $this->member = $member;
        $this->clientInterface = $clientInterface;
        $this->videosListService = $videosListService;
    }

    /**
     * Youtube Data API Search_Listを叩く
     *
     * @return void
     */
    public function requestSearchList()
    {
        $method = "GET";
        $videos = array();

        $members = $this->member->getAllMembers();
        foreach ($members as $member) {
            $channelId = $member->channel_id;
            $url = $this->setUrl($channelId);

            $response = $this->clientInterface->firstRequest($method, $url);

            if ($response instanceof ClientException || $response instanceof RequestException) {
                //メインのAPIキーが使えなかった場合、別プロジェクトのAPIキーを使用
                $url = $this->subSetUrl($channelId);
                $response = $this->clientInterface->secondRequest($method, $url);
            }

            $body = $response->getBody();
            $video = json_decode($body, true);

            if (!empty($video["items"])) {
                //配信予定が一つだけの場合
                if (count($video["items"]) == "1") {
                    $videoId = $video["items"][0]["id"]["videoId"];
                    $interval = $this->videosListService->checkDiffToday($videoId);

                    if ($interval <= "10") {
                        $this->storageVideoInfo($video["items"][0], $video["regionCode"]);
                    }
                }

                // 配信予定が複数ある場合
                if (count($video["items"]) > "1") {
                    $videoIds = $this->storageVideoIds($video["items"]);
                    $videoInfoArr = array();
                    foreach ($videoIds as $key => $videoId) {
                        $interval = $this->videosListService->checkDiffToday($videoId);

                        if ($interval <= "10") {
                            dd($video);
                            $videoInfo = $this->storageVideoInfo($video["items"][$key], $video["regionCode"]);
                            array_push($videoInfoArr, $videoInfo);
                            dd($videoInfoArr);
                        }
                    }
                }
            }
        }
        dd($videos);
        $this->storeDailyUpcomingVideos($videos);
    }

    /**
     * メインAPIキーを使用
     *
     * @param int $channelId
     * @return string
     */
    public function setUrl($channelId)
    {
        return "https://www.googleapis.com/youtube/v3/search?key=" . config('app.API_KEY') . "&channel_id=" . $channelId . "&part=snippet&eventType=upcoming&type=video";
    }

    /**
     * サブAPIキーを使用
     *
     * @param string $channelId
     * @return string
     */
    public function subSetUrl($channelId)
    {
        return "https://www.googleapis.com/youtube/v3/search?key=" . config('app.SUB_API_KEY') . "&channel_id=" . $channelId . "&part=snippet&eventType=upcoming&type=video";
    }

    public function storageVideoIds($items)
    {
        $videoIds = array();
        foreach ($items as $item) {
            $videoId = $item["id"]["videoId"];
            array_push($videoIds, $videoId);
        }

        return $videoIds;
    }

    public function storageVideoInfo($video, $regionCode)
    {
        $videoInfo = array();
        $videoId = $video["id"]["videoId"];
        $channelId = $video["snippet"]["channelId"];
        $title = $video["snippet"]["title"];
        $thumbnails = $video["snippet"]["thumbnails"]["medium"]["url"];

        $date = $this->videosListService->getScheduledStartTime($videoId);
        $scheduleStartTime = $date->format('Y-m-d');

        array_push($videoInfo, $regionCode, $videoId, $channelId, $title, $thumbnails, $scheduleStartTime);

        return $videoInfo;
    }

    /**
     * Undocumented function
     *
     * @param array $videos
     * @param array $video
     * @return array
     */
    public function storageVideos($videos, $video)
    {
        return array_merge($videos, $video);
    }

    public function storeDailyUpcomingVideos($videos)
    {
        // DB::table('daily_upcoming_videos')->insert([
        //     ['video_id' => $video['items']]
        // ])
    }
}
