<?php

namespace App\Repositories;

use App\Models\Member;

class MemberRepository
{
    public function __construct(Member $member)
    {
        $this->member = $member;
    }

    public function fetchAllMembers()
    {
        return $this->member->all();
    }
}
