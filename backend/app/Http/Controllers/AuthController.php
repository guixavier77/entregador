<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterUserRequest;
use App\Models\User;
use App\Repositories\AuthRepository;
use Exception;
use Illuminate\Http\Request;
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

    public function loginUser(LoginRequest $request)
    {
        $authResult = $this->repository->auth($request->validated());

        if ($authResult) {
            return response()->json(['message' => 'User loggedIn.', 'bearer_token' => $authResult], Response::HTTP_OK);
        }
        return response()->json(['message' => 'The credentials not matches.'], Response::HTTP_UNAUTHORIZED);
    }

    public function logoutUser(Request $request, User $user)
    {
        $error = $this->repository->logout($user);

        if (!$error) {
            return response()->json(['message' => 'User logout.'], Response::HTTP_OK);
        }
        return response()->json(['message' => $error], Response::HTTP_INTERNAL_SERVER_ERROR);
    }
}
