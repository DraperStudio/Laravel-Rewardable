<?php

namespace DraperStudio\Rewardable\Traits;

use DraperStudio\Rewardable\Models\Credit;
use DraperStudio\Rewardable\Repositories\CreditRepository;

trait Creditable
{
    public function credits()
    {
        return $this->morphMany(Credit::class, 'creditable');
    }

    public function getCredit()
    {
        return $this->getCreditRepository()->getTotalCredit();
    }

    public function getCreditByType($type)
    {
        return $this->getCreditRepository()->getTotalCreditByType($type);
    }

    public function getBalance()
    {
        return $this->getCreditRepository()->getBalance();
    }

    public function getBalanceByType($type)
    {
        return $this->getCreditRepository()->getBalanceByType($type);
    }

    public function getSpendCredits()
    {
        return $this->transactions->sum('amount');
    }

    public function grantCredit($credit)
    {
        return $this->getCreditRepository()->grantCredit($credit);
    }

    public function grantCredits($credits)
    {
        return $this->getCreditRepository()->grantCredits($credits);
    }

    public function revokeCredit($credit)
    {
        return $this->getCreditRepository()->revokeCredit($credits);
    }

    public function revokeCredits($credits)
    {
        return $this->getCreditRepository()->revokeCredits($credits);
    }

    public function revokeAllCredits()
    {
        return $this->getCreditRepository()->revokeAllCredits();
    }

    public function reGrantCredits($credits)
    {
        return $this->getCreditRepository()->reGrantCredits($credits);
    }

    private function getCreditRepository()
    {
        return new CreditRepository($this);
    }
}
