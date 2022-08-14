<?php

namespace App\Services;

use App\Repositories\MemberRepository;

class MemberService
{
    public function __construct(MemberRepository $memberRepository)
    {
        $this->memberRepository = $memberRepository;
    }

    public function fetchAll()
    {
        return $this->memberRepository->fetchAllMembers();
    }
}
