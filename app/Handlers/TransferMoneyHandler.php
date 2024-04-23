<?php

namespace App\Handlers;

use App\Repository\AccountRepository;
use App\Repository\TransferRepository;
use Illuminate\Http\Request;

class TransferMoneyHandler
{
    public function __construct(
        private AccountRepository $accountRepository,
        private TransferRepository $transferRepository,
    ) {
    }

    public function handle(Request $request, int $senderUserId)
    {
        $senderAccount = $this->accountRepository->getAccountById($senderUserId);
        if ($senderAccount->balance < $request->amount) {
            throw new \Exception('Saldo insuficiente para realizar a operação');
        }
        $receiverAccount = $this->accountRepository->getAccountByAccountNumber($request->receiverAccount);
        if ($senderAccount->account_number == $receiverAccount->account_number) {
            throw new \Exception('Você não pode transferir dinheiro para a sua própria conta');
        }
        $authorizationCode = $this->transferRepository->create(
            $senderAccount->id,
            $receiverAccount->user_id,
            $request->amount
        );
        $senderAccount->decrement('balance', $request->amount);
        $receiverAccount->increment('balance', $request->amount);

        return $authorizationCode;
    }
}
