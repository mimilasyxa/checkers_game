<?php

namespace App\Services\Lobby;

enum LobbyStatusEnum: string
{
    case Awaits = 'Awaits';
    case Running = 'Running';
    case Finished = 'Finished';
}
