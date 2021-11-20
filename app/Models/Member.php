<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    protected $table = 'HOLOLIVE_MEMBER_MST';

    public function getAllMembers() {
        return Member::all();
    }
}
