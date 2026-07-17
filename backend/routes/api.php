<?php

use App\Http\Controllers\Lobby\LobbyController;
use App\Http\Middleware\Auth\CheckAuthTokenMiddleware;
use Illuminate\Support\Facades\Route;

Route::prefix('lobby')
    ->middleware(CheckAuthTokenMiddleware::class)
    ->group(function () {
        Route::post('/start', [LobbyController::class, 'checkStart']);
        Route::post('/join', [LobbyController::class, 'joinLobby']);
});
