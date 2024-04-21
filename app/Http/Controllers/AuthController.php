<?php

namespace App\Http\Controllers;

use App\Http\Response;
use Illuminate\Http\Request;
use App\Services\AuthService;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function __construct(private AuthService $authService)
    {}

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'fullname' => 'required|string|min:2|max:255',
            'email' => 'required|string|email:rfc,dns|max:255|unique:users',
            'password' => 'required|string|min:6|max:255',
            'cpf' => 'required|string',
            'address.zipcode' => 'required|string',
            'address.street' => 'required|string',
            'address.number' => 'required|int',
            'address.state' => 'required|string',
            'address.city' => 'required|string',
        ]);
        if ($validator->fails()) {
            $response = Response::array(true, 'Houve um erro de validação', [$validator->errors()]);

            return response()->json($response, 400);
        }
        try {
            $token = $this->authService->register($request);
            $response = Response::array(false, 'Usuário criado com sucesso', [
                'user' => [
                    'fullname' => $request->fullname,
                    'email' => $request->email,
                ],
                'token' => $token,
            ]);

            return response()->json($response, 200);
        } catch (\Exception $e) {
            $response = Response::array(true, $e->getMessage(), []);

            return response()->json($response, 400);
        }
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string',
            'password' => 'required|string',
        ]);
        if ($validator->fails()) {
            $response = Response::array(true, 'Houve um erro de validação', [$validator->errors()]);

            return response()->json($response, 400);
        }
        try {
            $token = $this->authService->checkLogin($request);
            $response = Response::array(false, 'Usuário recuperado com sucesso', [
                'user' => auth()->user(),
                'token' => $token,
            ]);

            return response()->json($response);
        } catch(\Exception $e) {
            $response = Response::array(true, $e->getMessage(), []);

            return response()->json($response, $e->getCode());
        }
    }

    public function logout()
    {
        $token = JWTAuth::getToken();
        $invalidate = JWTAuth::invalidate($token);

        if ($invalidate) {
            return response()->json([
                'code' => 200,
                'status' => 'success',
                'message' => 'Usuário deslogado com sucesso',
                'data' => [],
            ]);
        }
    }
}
