<?php

namespace App\Services;

use App\Models\Account;
use App\Models\User;
use App\Repository\AccountRepository;
use App\Repository\AddressRepository;
use App\Repository\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthService
{
    public function __construct(
        private UserRepository $userRepository,
        private AddressRepository $addressRepository,
        private AccountRepository $accountRepository,
    ) {}

    public function register(Request $request)
    {
        $address = $this->addressRepository->create($request->address);
        $userData = [
            'address_id' => $address->id,
            'fullname' => $request->fullname,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'cpf' => $request->cpf,
        ];
        $user = $this->userRepository->create($userData);
        $accountData = [
            'user_id' => $user->id,
            'account_number' => Account::generateRandomAccountNumber(),
        ];
        $this->accountRepository->create($accountData);

        return $this->generateToken($user);
    }

    public function checkLogin(Request $request)
    {
        $token = auth()->attempt(['email' => $request->email, 'password' => $request->password]);
        if (!$token) {
            throw new \Exception('Usuário e/ou senha inválidos', 401);
        }

        return $token;
    }

    private function generateToken(User $user)
    {
        return Auth::login($user);
    }
}
