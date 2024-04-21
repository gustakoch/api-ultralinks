<?php

namespace App\Jobs;

use Illuminate\Support\Facades\Mail;
use App\Mail\DepositConfirmation;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;

class ProcessDeposit implements ShouldQueue
{
    protected $user;
    protected $authorizationCode;
    protected $amount;

    public function __construct(User $user, $authorizationCode, $amount)
    {
        $this->user = $user;
        $this->authorizationCode = $authorizationCode;
        $this->amount = $amount;
    }

    public function handle()
    {
        Mail::to($this->user->email)->send(new DepositConfirmation(
            $this->user,
            $this->authorizationCode,
            $this->amount
        ));
    }
}
