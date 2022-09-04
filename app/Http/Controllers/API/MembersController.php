<?php

namespace App\Http\Controllers\Api;

use App\Services\MemberService;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Collection;

class MembersController extends Controller
{
    /**
     * @param MemberService $memberService
     */
    public function __construct(MemberService $memberService)
    {
        $this->memberService = $memberService;
    }

    /**
     * メンバー一覧表示
     *
     * @return Collection
     */
    public function index(): Collection
    {
        return $this->memberService->fetchAll();
    }

    /**
     * JPメンバー取得
     *
     * @return Collection
     */
    public function fetchJp(): Collection
    {
        return $this->memberService->fetchJp();
    }

    /**
     * ENメンバー取得
     *
     * @return Collection
     */
    public function fetchEn(): Collection
    {
        return $this->memberService->fetchEN();
    }

    /**
     * IDメンバー取得
     *
     * @return Collection
     */
    public function fetchId(): Collection
    {
        return $this->memberService->fetchId();
    }
}
