import {joinLobby, startLobby} from "./lobbyLogic.js";

const lobbyCreateOverlay = document.getElementById('modalOverlayCreation');
const createButton = document.querySelector('.create-btn');
const closeCreateBtn = document.querySelector('.close-create-popup-btn');
const lobbyCode = document.querySelector('.lobby-code')

const lobbyJoinOverlay = document.getElementById('modalOverlayJoining');
const joinButton = document.querySelector('.join-btn');
const closeJoinBtn = document.querySelector('.close-join-popup-btn');
const joinCodeInput = document.querySelector('.join-code-input')

const enterJoinCodeBtn = document.querySelector('.enter-join-code-btn')

const CODE_CHARACTERS = "ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890"
const CODE_KEY = 'CODE_KEY'
const AWAITS_PLAYER_KEY = 'AWAITS_PLAYER'
function updateJoinCode() {
    let code = localStorage.getItem(CODE_KEY)
    if (code == null) {
        let code = generateLobbyCode()
        localStorage.setItem(CODE_KEY, code)
    }
    lobbyCode.innerHTML = code
    return code
}

createButton.addEventListener('click', function ()  {
    lobbyCreateOverlay.classList.add('active');
    let code = updateJoinCode()
    changeWaitStatus(true)
    startLobby(code)
        .then(function (result) {
            if (result.error) {
                lobbyCreateOverlay.querySelector('.error').innerHTML = result.error;
                return
            }
            lobbyCreateOverlay.querySelector('.loader-container').classList.add('active');
            window.Echo.channel('Lobby_' + code)
                .listen('.GameStartingEvent', () => {
                    console.log('GAME_STARTING_EVENT')
                });
        })
});
closeCreateBtn.addEventListener('click', function () {
    lobbyCreateOverlay.classList.remove('active')
    lobbyCreateOverlay.querySelector('.error').innerHTML = '';
    lobbyCreateOverlay.querySelector('.loader-container').classList.remove('active');
    changeWaitStatus(false)
});

joinButton.addEventListener('click', function () {
    lobbyJoinOverlay.classList.add('active');
})
closeJoinBtn.addEventListener('click', function () {
    lobbyJoinOverlay.classList.remove('active')
    joinCodeInput.value = ''
});

enterJoinCodeBtn.addEventListener('click', function () {
   let code = joinCodeInput.value
   joinLobby(code).then(
       (data) => {
           console.log(data)
           window.Echo.channel('Lobby_' + code)
               .listen('.GameStartingEvent', () => {
                   console.log('GAME_STARTING_EVENT')
               });
       }
   )
});

function changeWaitStatus(value) {
    localStorage.setItem(AWAITS_PLAYER_KEY, value)
}

function generateLobbyCode() {
    let code = ''
    let length = CODE_CHARACTERS.length
    for (let i=0; i < 7; i++) {
        code += CODE_CHARACTERS[Math.round(Math.random() * (length -1))]
    }
    return code
}
