<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterDelivererRequest;
use App\Http\Requests\RegisterUserRequest;
use App\Models\Address;
use App\Models\Deliverer;
use App\Models\User;
use App\Repositories\AuthRepository;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
  

    public function registerUser(RegisterUserRequest $request)
    {

        
        $data = $request->validated();
        $data['password'] = Hash::make($request->password);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $data['password'],
            'image' => $data['image'],
            'cpf' => $data['cpf'],
            'phone' => $data['phone'], 
        ]);
         Address::create([
            'street' =>  $data['street'],
            'neighborhood' =>  $data['neighborhood'],
            'number' => $data['number'],
            'city' => $data['city'],	
            'state' => $data['state'],
            'user_id' => $user->id
        ]);
        $token = $user->createToken($user->email)->plainTextToken;

        return response()->json([
            'message' => 'Usuário cadastrado com sucesso.',
            'Bearer_token' => $token,
            'user' => $user
        ], Response::HTTP_OK);
       
    }

    public function registerDeliverer(RegisterDelivererRequest $request){
        $data = $request->validated();
        $data['password'] = Hash::make($request->password);

        $deliverer = Deliverer::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $data['password'],
            'image' => $data['image'],
            'cnh_image' => $data['cnh_image'],
            'cpf' => $data['cpf'],
            'phone' => $data['phone'], 
        ]);
         $deliverer->address()->create([
            'street' =>  $data['street'],
            'neighborhood' =>  $data['neighborhood'],
            'number' => $data['number'],
            'city' => $data['city'],	
            'state' => $data['state'],
            'deliverer_id' => $deliverer->id
        ]);
        $deliverer->vehicles()->create([
            'plaque' =>  $data['plaque'],
            'color' =>  $data['color'],
            'model' => $data['model'],
            'document' => $data['document'],	
            'deliverer_id' => $deliverer->id
        ]);
        $token = $deliverer->createToken($deliverer->email)->plainTextToken;

        return response()->json([
            'message' => 'Usuário cadastrado com sucesso.',
            'Bearer_token' => $token,
            'deliverer' => $deliverer
        ], Response::HTTP_OK);
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
