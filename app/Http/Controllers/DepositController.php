<?php

namespace App\Http\Controllers;

use App\Handlers\DepositMoneyHandler;
use App\Http\Response;
use App\Jobs\ProcessDeposit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Facades\Validator;

class DepositController extends Controller
{
    public function __construct(private DepositMoneyHandler $depositMoneyHandler)
    {}

    public function deposit(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'accountNumber' => 'required|exists:accounts,account_number',
            'amount' => 'required|numeric|min:0',
        ]);
        if ($validator->fails()) {
            $response = Response::array(true, 'Houve um erro de validação', [$validator->errors()]);

            return response()->json($response);
        }
        try {
            $authorizationCode = $this->depositMoneyHandler->handle($request);
            Queue::pushOn('deposit_queue', new ProcessDeposit(
                auth()->user(),
                $authorizationCode,
                $request->amount
            ));
            $response = Response::array(false, 'Depósito realizado com sucesso', [
                'authorizationCode' => $authorizationCode
            ]);

            return response()->json($response);
        } catch(\Exception $e) {
            $response = Response::array(true, $e->getMessage(), []);

            return response()->json($response, 400);
        }
    }
}
