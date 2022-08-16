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
        return $this->memberRepository->fetchAll();
    }

    public function fetchJp()
    {
        return $this->memberRepository->fetchJp();
    }

    public function fetchEn()
    {
        return $this->memberRepository->fetchEn();
    }

    public function fetchId()
    {
        return $this->memberRepository->fetchId();
    }
}
