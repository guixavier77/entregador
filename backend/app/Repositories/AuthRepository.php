<?php

namespace App\Repositories;

use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Auth;

class AuthRepository
{
    public function store(array $payload): bool
    {
        $payload['password'] = bcrypt($payload['password']);

        if (User::create($payload)) {
            return true;
        }
        return false;
    }

    public function auth(array $payload)
    {
        $token = null;

        if (Auth::attempt($payload)) {
            $user = User::where('email', $payload['email'])->first();
            $this->logout($user);
            $token = $user->createToken($user->email);
            $token = $token->plainTextToken;
        }

        return $token;
    }

    public function logout($user)
    {
        try {
            $user->tokens()->delete();
            return null;

        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}
