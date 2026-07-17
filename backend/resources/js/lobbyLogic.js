import {makeApiCall} from "./apiService.js";
export async function startLobby(lobbyCode) {
    return await makeApiCall('POST', 'start', {lobbyCode: lobbyCode})
}

export async function joinLobby(lobbyCode) {
    return await makeApiCall('POST', 'join', {lobbyCode: lobbyCode})
}
