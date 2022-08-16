<?php

namespace App\Repositories;

use App\Models\Member;

class MemberRepository
{
    public function __construct(Member $member)
    {
        $this->member = $member;
    }

    public function fetchAll()
    {
        return $this->member->all();
    }

    public function fetchJp()
    {
        return $this->member->where('country', 'JP')->get();
    }

    public function fetchEn()
    {
        return $this->member->where('country', 'EN')->get();
    }

    public function fetchId()
    {
        return $this->member->where('country', 'ID')->get();
    }
}
