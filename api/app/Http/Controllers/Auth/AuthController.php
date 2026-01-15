<?php

namespace App\Http\Controllers\Auth;

use App\Messages\Auth\AuthMessages;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Services\User\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function __construct(
        protected UserService $userService
    ){}

    public function register(RegisterRequest $req)
    {
        return apiSuccess('Usuário cadastrado com sucesso!', $this->userService->store($req->validated(), $req->user()->id), true, 201);
    }

    public function login(Request $req)
    {
        $data = $req->validate([
            'email' => 'required|email',
            'password' => 'required'

        ], [
            'email.required' => AuthMessages::EMAIL_REQUIRED,
            'email.email' => AuthMessages::EMAIL_FORMAT,

            'password.required' => AuthMessages::PASSWORD_REQUIRED
        ]);

        $user = $this->userService->findByMail($data['email']);

        if($user && !Hash::check($data['password'], $user->password))
        {
            throw ValidationException::withMessages([
                'message' => 'Credenciais incorretas.'
            ]);
        }

        $token = $user->createToken('api-token')->plainTextToken;

        return apiSuccess('Login bem sucedido!', [
            'token' => $token,
            'user' => $user
        ]);
    }
}
