<?php

namespace App\Http\Controllers;

use App\Mail\resetPassword;
use App\Models\Deliverer;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\HttpFoundation\Response;

class ResetPasswordController extends Controller
{
    public function sendEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $user = User::where('email', $request->email)->first();
        if ($user) {
           $user->remember_token = substr(md5(time()), 0, 16);
           $user->save();

            Mail::send(new resetPassword($user));

            return response()->json(['message' => 'Verifique seu email para continuar.'], Response::HTTP_OK);
        }
        return response()->json(['message' => 'Usuário não encontrado.'], Response::HTTP_NOT_FOUND);
    }

    public function sendEmailDeliverer(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $user = Deliverer::where('email', $request->email)->first();
        if ($user) {
           $user->remember_token = substr(md5(time()), 0, 16);
           $user->save();

            Mail::send(new resetPassword($user));

            return response()->json(['message' => 'Verifique seu email para continuar.'], Response::HTTP_OK);
        }
        return response()->json(['message' => 'Usuário não encontrado.'], Response::HTTP_NOT_FOUND);
    }

    public function authCredentials($email, $token)
    {
        $isDeliverer = Deliverer::where('email', $email)->first();
        if ($isDeliverer) {
            if ($isDeliverer->remember_token === $token) {
                $isDeliverer->remember_token = null;
                $isDeliverer->save();
                $token = $isDeliverer->createToken($isDeliverer->email)->plainTextToken;

                //autenticar o usuário para ele aterar a senha
                return response()->json([
                    'message' => 'Você poderá alterar sua senha agora.',
                    'Bearer_token' => $token,
                    'Deliverer' => $isDeliverer
                ], Response::HTTP_OK);
            }
            return response()->json(['message' => 'Credenciais incorretas'], Response::HTTP_UNAUTHORIZED);
        }
        else {
            $user = User::where('email', $email)->first();
            if ($user->remember_token === $token) {
                $user->remember_token = null;
                $user->save();
                $token = $user->createToken($user->email)->plainTextToken;

                //autenticar o usuário para ele aterar a senha
                return response()->json([
                    'message' => 'Você poderá alterar sua senha agora.',
                    'Bearer_token' => $token,
                    'user' => $user
                ], Response::HTTP_OK);
            }
            return response()->json(['message' => 'Credenciais incorretas'], Response::HTTP_UNAUTHORIZED);
        }
    }
}
