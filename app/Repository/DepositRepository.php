<?php

namespace App\Repository;

use App\Models\Deposit;

class DepositRepository
{
    public function create($accountId, $amount)
    {
        $authorizationCode = 'DEP' . str_pad(mt_rand(1, 9999), 4, '0', STR_PAD_LEFT);
        Deposit::create([
            'account_id' => $accountId,
            'amount' => $amount,
            'authorization_code' => $authorizationCode,
        ]);

        return $authorizationCode;
    }
}
