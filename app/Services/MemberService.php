<?php

namespace App\Services;

use App\Repositories\MemberRepository;

class MemberService
{
    /**
     * @param MemberRepository $memberRepository
     */
    public function __construct(MemberRepository $memberRepository)
    {
        $this->memberRepository = $memberRepository;
    }

    /**
     * @return Collection
     */
    public function fetchAll(): Collection
    {
        return $this->memberRepository->fetchAll();
    }

    /**
     * @return Collection
     */
    public function fetchJp(): Collection
    {
        return $this->memberRepository->fetchJp();
    }

    /**
     * @return Collection
     */
    public function fetchEn(): Collection
    {
        return $this->memberRepository->fetchEn();
    }

    /**
     * @return Collection
     */
    public function fetchId(): Collection
    {
        return $this->memberRepository->fetchId();
    }
}
