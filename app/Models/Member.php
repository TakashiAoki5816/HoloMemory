<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    protected $table = 'HOLOLIVE_MEMBER_MST';

    /**
     * 所属している全メンバーを取得
     *
     * @return Member
     */
    public function getAllMembers()
    {
        return Member::all();
    }
}
