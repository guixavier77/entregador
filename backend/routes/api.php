<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ResetPasswordController;
use Illuminate\Support\Facades\Route;


Route::post('/register', [AuthController::class, 'registerUser'])->name('auth.register');
Route::post('/register-deliverer', [AuthController::class, 'registerDeliverer'])->name('auth.registerDeliverer');

//rota de login para usuário comum
Route::post('/login-client', [AuthController::class, 'loginClient'])->name('auth.loginClient');

//rota de login para usuário entregador
Route::post('/login-deliverer', [AuthController::class, 'loginDeliverer'])->name('auth.loginDeliverer');

//rota para enviar email de recuperação, o usuário insere o email dele
Route::post('/forget-client', [ResetPasswordController::class, 'sendEmail'])->name('reset.sendEmail');
Route::post('/forget-deliverer', [ResetPasswordController::class, 'sendEmailDeliverer'])->name('reset.sendEmailDeliverer');

//quando o usuário clicar no link, o front redireciona para rota de reset-client ou reset-deliverer
Route::get('/{email}/{token}', [ResetPasswordController::class, 'authCredentials'])->name('authCredentials');



Route::middleware('auth:sanctum')->group(function () {
    //Somente os usuários logados acessam essas rotas

    //rota para alterar a senha do usuário
    Route::post('/reset-client', [AuthController::class, 'resetClient'])->name('auth.resetClient');
    Route::post('/reset-deliverer', [AuthController::class, 'resetDeliverer'])->name('auth.resetDeliverer');

    //logout do usuário comum, passando o id do usuário
    Route::post('/logout-client/{user}', [AuthController::class, 'logoutClient'])->name('auth.logoutClient');

    //logout do entregador, passando o id do entregador
    Route::post('/logout-deliverer/{deliverer}', [AuthController::class, 'logoutDeliverer'])->name('auth.logoutDeliverer');
});
