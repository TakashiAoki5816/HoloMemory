<?php

namespace App\Models;

use App\Models\DailyUpcomingVideos;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    protected $table = 'HOLOLIVE_MEMBER_MST';

    public function daily_upcoming_videos()
    {
        return $this->hasMany(DailyUpcomingVideos::class);
    }

    /**
     * 所属している全メンバーを取得
     *
     * @return Member
     */
    public function getAllMembers()
    {
        return $this::all();
    }
}
