<?php

namespace App\Services;

use App\Repositories\MemberRepository;
use Illuminate\Database\Eloquent\Collection;

class MemberService
{
    /**
     * @param MemberRepository $memberRepository
     */
    public function __construct(MemberRepository $memberRepository)
    {
        $this->memberRepository = $memberRepository;
    }
}
