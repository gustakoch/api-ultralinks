<?php

namespace App\Http\Controllers;

use App\Http\Response;

class LoginController extends Controller
{
    public function login()
    {
        $response = Response::array(true, 'Usuário não autenticado. Faça login na aplicação', []);

        return response()->json($response, 401);
    }
}
