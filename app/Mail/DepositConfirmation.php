<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class DepositConfirmation extends Mailable
{
    use Queueable;
    use SerializesModels;

    private $authorizationCode;
    private $amount;
    private $user;

    public function __construct($user, $authorizationCode, $amount)
    {
        $this->authorizationCode = $authorizationCode;
        $this->amount = $amount;
        $this->user = $user;
    }

    public function build()
    {
        return $this->view('emails.deposit_confirmation')
                    ->with([
                        'authorizationCode' => $this->authorizationCode,
                        'amount' => $this->amount,
                        'fullname' => $this->user->fullname,
                    ])
                    ->subject('Confirmação de depósito');
    }
}
