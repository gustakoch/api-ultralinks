<?php

namespace App\Http\Controllers;

use App\Handlers\TransferMoneyHandler;
use App\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class TransferController extends Controller
{
    public function __construct(private TransferMoneyHandler $transferMoneyHandler)
    {
    }

    public function transfer(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'receiverAccount' => 'required|exists:accounts,account_number',
            'amount' => 'required|numeric|min:0',
        ]);
        if ($validator->fails()) {
            $response = Response::array(true, 'Houve um erro de validação', [$validator->errors()]);

            return response()->json($response);
        }
        try {
            $authorizationCode = $this->transferMoneyHandler->handle($request, Auth::id());
            $response = Response::array(false, 'Transferência realizada com sucesso', [
                'authorizationCode' => $authorizationCode
            ]);

            return response()->json($response);
        } catch(\Exception $e) {
            $response = Response::array(true, $e->getMessage(), []);

            return response()->json($response, 400);
        }
    }
}
