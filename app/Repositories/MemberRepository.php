<?php

namespace App\Repositories;

use App\Models\Member;
use Illuminate\Database\Eloquent\Collection;

class MemberRepository
{
    /**
     * @param Member $member
     */
    public function __construct(Member $member)
    {
        $this->member = $member;
    }

    /**
     * 選択されたグループのメンバー一覧を取得
     * @param string $selectedGroup
     * @return Collection
     */
    public function fetchAllBySelectedGroup(string $selectedGroup): Collection
    {
        if ($selectedGroup === 'ALL') {
            return $this->member->all();
        }

        return $this->member->where('country', $selectedGroup)->get();
    }
}
