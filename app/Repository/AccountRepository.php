<?php

namespace App\Repository;

use App\Models\Account;

class AccountRepository
{
    public function create(array $data)
    {
        return Account::create($data);
    }

    public function getAccountById($id)
    {
        return Account::where('user_id', $id)->first();
    }

    public function getAccountByAccountNumber($accountNumber)
    {
        return Account::where('account_number', $accountNumber)->first();
    }
}
