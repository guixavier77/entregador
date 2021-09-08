<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterUserRequest;
use App\Models\Deliverer;
use App\Models\User;
use App\Repositories\AuthRepository;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    private $repository;

    public function __construct(AuthRepository $repository)
    {
        $this->repository = $repository;
    }

    public function registerUser(RegisterUserRequest $request)
    {
        try {
            $this->repository->store($request->validated());

            return response()->json(['message' => 'User created.'], Response::HTTP_CREATED);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function loginClient(LoginRequest $request)
    {
        $token = null;

        if (Auth::attempt($request->validated())) {
            $user = User::where('email', $request->email)->first();
            $user->tokens()->delete();
            $token = $user->createToken($user->email);
            $token = $token->plainTextToken;

            return response()->json([
                'message' => 'Usuário logado com sucesso.',
                'Bearer_token' => $token,
                'user' => $user
            ], Response::HTTP_OK);
        }
        return response()->json(['message' => 'Email ou senha incorretos.'], Response::HTTP_UNAUTHORIZED);
    }

    public function loginDeliverer(LoginRequest $request)
    {
        if (Auth::guard('deliverer')->attempt($request->validated())) {
            $user = Deliverer::where('email', $request->email)->first();
            $user->tokens()->delete();
            $token = $user->createToken($user->email);
            $token = $token->plainTextToken;

            return response()->json([
                'message' => 'Usuário logado com sucesso.',
                'Bearer_token' => $token,
                'user' => $user
            ], Response::HTTP_OK);
        }
        return response()->json(['message' => 'Email ou senha incorretos.'], Response::HTTP_UNAUTHORIZED);
    }

    public function logoutClient(User $user)
    {
        $user->tokens()->delete();
        return response()->json(['message' => 'Logout concluído com sucesso.'], Response::HTTP_OK);
    }
    public function logoutDeliverer(Deliverer $deliverer)
    {
        $deliverer->tokens()->delete();
        return response()->json(['message' => 'Logout concluído com sucesso.'], Response::HTTP_OK);
    }
}
