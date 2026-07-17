<?php

namespace App\Services\Lobby;

use App\Events\Game\GameStartingEvent;
use App\Models\Lobby\Lobby;
use App\Services\Cache\CacheService;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use function Pest\Laravel\json;

class LobbyService
{
    public const string LOBBY_KEY = 'LOBBY_KEY_';
    public const int LOBBY_EXPIRE_TIME = 3600 ;// 60 * 60 = 1 час
    public const string CONTESTANTS_KEY = '_CONTESTANTS';
    public function __construct(
        protected CacheService $cacheService
    )
    {
    }

    public function startNewLobby(string $lobbyCode, string $fingerprint): bool
    {
        $this->cacheService->setCache(self::LOBBY_KEY . $lobbyCode, LobbyStatusEnum::Awaits->value, self::LOBBY_EXPIRE_TIME);
        $this->cacheService->setCache($lobbyCode . self::CONTESTANTS_KEY,  json_encode([$fingerprint]),  self::LOBBY_EXPIRE_TIME);
        return true;
    }

    public function joinLobby(string $lobbyCode, string $fingerprint): bool
    {
        if (!$this->cacheService->getCache(self::LOBBY_KEY . $lobbyCode)) {
            throw new NotFoundHttpException('Lobby not found');
        }

        $lobby = $this->createLobby($lobbyCode);

        $firstPlayerCache = $this->cacheService->getCache($lobbyCode . self::CONTESTANTS_KEY);

        $firstPlayerFingerprint = json_decode($firstPlayerCache, true);
        //dd($firstPlayerFingerprint);
        broadcast(new GameStartingEvent($lobbyCode));
        return true;
    }

    private function createLobby(string $lobbyCode): Lobby
    {
        $lobby = new Lobby();

        $lobby->setCode($lobbyCode);
        $lobby->setStatus(LobbyStatusEnum::Awaits->value);

        return $lobby;
    }
}
