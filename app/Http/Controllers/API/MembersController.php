<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\MemberRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class MembersController extends Controller
{
    /**
     * @param MemberRepository $memberRepository
     */
    public function __construct(MemberRepository $memberRepository)
    {
        $this->memberRepository = $memberRepository;
    }

    /**
     * メンバー一覧表示
     *
     * @param Request $request
     * @return Collection
     */
    public function index(Request $request): Collection
    {
        $selectedGroup = $request->query('group');
        return $this->memberRepository->fetchAllBySelectedGroup($selectedGroup);
    }
}
