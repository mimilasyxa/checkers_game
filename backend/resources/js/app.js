//

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allow your team to quickly build robust real-time web applications.
 */

import './echo';
import './menu-buttons.js';
import getBrowserFingerprint from "get-browser-fingerprint";

const AUTH_KEY = 'AUTH_KEY';
function setAuthToken(token) {
    let oldToken = localStorage.getItem(AUTH_KEY);
    if (oldToken == null) {
        localStorage.setItem(AUTH_KEY, token)
    }
}

export function getAuthToken() {
    return localStorage.getItem(AUTH_KEY);
}

setAuthToken(
    await getBrowserFingerprint()
)
