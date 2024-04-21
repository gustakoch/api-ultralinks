<?php

namespace App\Repository;

use App\Models\Transfer;

class TransferRepository
{
    public function create($senderAccountId, $receiverAccountId, $amount)
    {
        $authorizationCode = 'TRANSF' . str_pad(mt_rand(1, 9999), 4, '0', STR_PAD_LEFT);;
        Transfer::create([
            'sender_account_id' => $senderAccountId,
            'receiver_account_id' => $receiverAccountId,
            'amount' => $amount,
            'authorization_code' => $authorizationCode,
        ]);

        return $authorizationCode;
    }
}
