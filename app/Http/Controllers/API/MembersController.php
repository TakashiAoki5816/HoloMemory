<?php

namespace App\Http\Controllers\Api;

use App\Services\MemberService;
use App\Http\Controllers\Controller;

class MembersController extends Controller
{
    public function __construct(MemberService $memberService)
    {
        $this->memberService = $memberService;
    }

    public function index()
    {
        return $this->memberService->fetchAll();
    }

    // public function jp()
    // {
    //     return $this->memberService->
    // }
}
