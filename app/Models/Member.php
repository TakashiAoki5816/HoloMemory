<?php

namespace App\Models;

use App\Models\DailyUpcomingVideos;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    protected $table = 'HOLOLIVE_MEMBER_MST';

    public function daily_upcoming_videos(): object
    {
        return $this->hasMany(DailyUpcomingVideos::class);
    }

    /**
     * 所属している全メンバーを取得
     *
     * @return Collection
     */
    public function fetchAllMembers(): Collection
    {
        return $this->all();
    }
}
