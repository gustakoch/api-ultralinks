<?php

namespace App\Handlers;

use App\Repository\AccountRepository;
use App\Repository\DepositRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DepositMoneyHandler
{
    public function __construct(
        private AccountRepository $accountRepository,
        private DepositRepository $depositRepository,
    ) {
    }

    public function handle(Request $request)
    {
        $account = $this->accountRepository->getAccountByAccountNumber($request->accountNumber);
        if (Auth::id() == $account->id) {
            throw new \Exception(sprintf('Você não pode fazer um depósito na sua própria conta %s', $request->accountNumber));
        }
        $authorizationCode = $this->depositRepository->create($account->id, $request->amount);
        $account->increment('balance', $request->amount);

        return $authorizationCode;
    }
}
