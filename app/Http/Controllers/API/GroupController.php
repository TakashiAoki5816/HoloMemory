<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Group;

class GroupController extends Controller
{
    public function __construct(Group $group)
    {
        $this->group = $group;
    }

    public function index()
    {
        return $this->group->getAllGroups();
    }
}
