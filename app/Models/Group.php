<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $table = 'HOLOLIVE_GROUP_MST';

    public function getAllGroups()
    {
        return $this->all();
    }
}
