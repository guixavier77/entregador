<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;


Route::post('/register', [AuthController::class, 'registerUser'])->name('auth.register');

//rota de login para usuário comum
Route::post('/login-client', [AuthController::class, 'loginClient'])->name('auth.loginClient');


Route::middleware('auth:sanctum')->group(function () {
    //Somente os usuários logados acessam essas rotas

    //logout do usuário comum, passando o id do usuário
    Route::post('/logout-client/{user}', [AuthController::class, 'logoutClient'])->name('auth.logoutClient');
});
