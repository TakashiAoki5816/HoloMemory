<?php

namespace App\Services\Youtube;

use App\Consts\SearchListServiceConsts;
use App\Models\Member;
use App\Repositories\Guzzle\GuzzleRepositoryInterface;
use App\Services\Youtube\VideosListService;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class SearchListService
{
    protected $clientInterface;
    protected $videosListService;

    /**
     * @param GuzzleRepositoryInterface $clientInterface
     * @param VideosListService $videosListService
     */
    public function __construct(GuzzleRepositoryInterface $clientInterface, VideosListService $videosListService)
    {
        $this->clientInterface = $clientInterface;
        $this->videosListService = $videosListService;
    }

    /**
     * Youtube Data API Search_Listを叩き、daily_upcoming_videosに格納
     *
     * @return void
     */
    public function requestSearchList($members)
    {
        $videos = $this->request($members);
        $params = $this->storeParamsFromVideos($videos);
        $this->insertDailyUpcomingVideos($params);
    }

    /**
     * $videosに配信予定一覧を格納
     *
     * @param Member $members
     * @return array $videos
     */
    public function request($members)
    {
        $videos = array();

        foreach ($members as $member) {
            $url = $this->setUrl($member->channel_id);

            $clientResponse = $this->clientInterface->firstRequest($url);
            if ($clientResponse instanceof ClientException || $clientResponse instanceof RequestException) {
                //メインのAPIキーが使えなかった場合、別プロジェクトのAPIキーを使用
                $url = $this->subSetUrl($member->channel_id);
                $clientResponse = $this->clientInterface->secondRequest($url);
            }

            $body = $clientResponse->getBody();
            $video = json_decode($body, true);

            if (!empty($video["items"])) {
                //配信予定が一つだけの場合
                if (count($video["items"]) == SearchListServiceConsts::ONE_VIDEO) {
                    $videoId = $video["items"][0]["id"]["videoId"];
                    $interval = $this->videosListService->checkDiffToday($videoId);

                    //１週間以内の動画を取得
                    if ($interval <= SearchListServiceConsts::ONE_WEEK) {
                        $videoInfoArr = array();
                        $videoInfo = $this->storageVideoInfo($video["items"][0], $member->country);

                        array_push($videoInfoArr, $videoInfo);
                        $videos = $this->storageVideoInfoArrToVideos($videos, $videoInfoArr);
                    }
                }

                // 配信予定が複数ある場合
                if (count($video["items"]) > SearchListServiceConsts::ONE_VIDEO) {
                    $videoIds = $this->storageVideoIds($video["items"]);
                    $videoInfoArr = $this->storageVideoInfoArr($videoIds, $video, $member->country);

                    $videos = $this->storageVideoInfoArrToVideos($videos, $videoInfoArr);
                }
            }
        }

        return $videos;
    }

    /**
     * メインAPIキーを使用
     *
     * @param string $channelId
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

    /**
     * 複数の動画IDを$videoIdsに格納
     *
     * @param array $items
     * @return array $videoIds
     */
    public function storageVideoIds($items)
    {
        $videoIds = array();
        foreach ($items as $item) {
            $videoId = $item["id"]["videoId"];
            array_push($videoIds, $videoId);
        }

        return $videoIds;
    }

    /**
     * 複数の動画情報を$videoInfoArrに格納
     *
     * @param array $videoIds
     * @param array $video
     * @param string $regionCOde
     */
    public function storageVideoInfoArr($videoIds, $video, $regionCode)
    {
        $videoInfoArr = array();
        foreach ($videoIds as $key => $videoId) {
            $interval = $this->videosListService->checkDiffToday($videoId);

            //１週間以内の動画を取得
            if ($interval <= SearchListServiceConsts::ONE_WEEK) {
                $videoInfo = $this->storageVideoInfo($video["items"][$key], $regionCode);
                array_push($videoInfoArr, $videoInfo);
            }
        }

        return $videoInfoArr;
    }

    /**
     * 動画情報を$videoInfoに格納
     *
     * @param array $video
     * @param string $regionCode
     * @return array $videoInfo
     */
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
     * 複数の配信情報を配信予定動画一覧（$videos）に格納
     *
     * @param array $videos
     * @param array $videoInfoArr
     * @return array $videos
     */
    public function storageVideoInfoArrToVideos($videos, $videoInfoArr)
    {
        return array_merge($videos, $videoInfoArr);
    }

    /**
     * 取得したデータを$paramsに格納
     *
     * @param array $videos
     * @return array $params
     */
    public function storeParamsFromVideos($videos)
    {
        $params = [];
        $now = Carbon::now();
        foreach ($videos as $video) {
            $params[] = [
                'country'              => $video['0'],
                'video_id'             => $video['1'],
                'channel_id'           => $video['2'],
                'title'                => $video['3'],
                'thumbnails_url'       => $video['4'],
                'scheduled_start_time' => $video['5'],
                'created_at'           => $now,
                'updated_at'           => $now,
            ];
        }

        return $params;
    }

    /**
     * daily_upcoming_videosに配信予定動画を挿入
     *
     * @param array $params
     * @return void
     */
    public function insertDailyUpcomingVideos($params)
    {
        DB::beginTransaction();

        DB::table('daily_upcoming_videos')->truncate();
        DB::table('daily_upcoming_videos')->insert($params);

        DB::commit();
    }
}
