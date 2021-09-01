<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;


Route::post('/register', [AuthController::class, 'registerUser'])->name('auth.register');
Route::post('/login', [AuthController::class, 'loginUser'])->name('auth.login');


Route::middleware('auth:sanctum')->group(function () {
    //Somente os usuários logados acessam essas rotas

    Route::post('/logout/{user}', [AuthController::class, 'logoutUser'])->name('auth.logout');
});
