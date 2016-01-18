<?php

namespace DraperStudio\Rewardable\Traits;

use DraperStudio\Rewardable\Exceptions\InsufficientFundsException;
use DraperStudio\Rewardable\Models\CreditType;
use DraperStudio\Rewardable\Models\Transaction;

trait Transactionable
{
    public function transactions()
    {
        return $this->morphMany(Transaction::class, 'transactionable');
    }

    public function chargeCredits($amount, $typeId)
    {
        // Check if the type of credit exists
        $type = CreditType::find($typeId);

        if (!$type) {
            return false;
        }

        // check if the Model has sufficient balance to trade
        if ($this->getBalanceByType($type->slug) < $amount) {
            throw new InsufficientFundsException(
                $this, $this->id, $this->getBalanceByType($type->id) - $amount
            );
        }

        // All fine, take the cash
        $transaction = (new Transaction())->fill([
            'amount' => $amount,
            'credit_type_id' => $type->id,
        ]);

        $this->transactions()->save($transaction);

        return $transaction;
    }
}
