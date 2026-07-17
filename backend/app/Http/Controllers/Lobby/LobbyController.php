<?php

namespace App\Http\Controllers\Lobby;

use App\Helpers\AuthHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Lobby\CreateLobbyRequest;
use App\Http\Requests\Lobby\JoinLobbyRequest;
use App\Http\Resources\Common\BoolResource;
use App\Services\Lobby\LobbyService;

class LobbyController extends Controller
{
    public function checkStart(CreateLobbyRequest $request, LobbyService $lobbyService): BoolResource
    {
        return BoolResource::make($lobbyService->startNewLobby($request->getLobbyCode(), AuthHelper::fingerprint()));
    }

    public function joinLobby(JoinLobbyRequest $request, LobbyService $lobbyService): BoolResource
    {
        return BoolResource::make(
            $lobbyService->joinLobby($request->getLobbyCode(), AuthHelper::fingerprint())
        );
    }
}
