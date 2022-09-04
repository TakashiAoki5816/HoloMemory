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
     * メンバー一覧取得
     *
     * @return Collection
     */
    public function fetchAll(): Collection
    {
        return $this->member->all();
    }

    /**
     * JPメンバー取得
     *
     * @return Collection
     */
    public function fetchJp(): Collection
    {
        return $this->member->where('country', 'JP')->get();
    }

    /**
     * ENメンバー取得
     *
     * @return Collection
     */
    public function fetchEn(): Collection
    {
        return $this->member->where('country', 'EN')->get();
    }

    /**
     * IDメンバー取得
     *
     * @return Collection
     */
    public function fetchId(): Collection
    {
        return $this->member->where('country', 'ID')->get();
    }
}
