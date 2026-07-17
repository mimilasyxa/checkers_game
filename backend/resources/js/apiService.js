import axios from 'axios';
import {getAuthToken} from "./app.js";
export async function makeApiCall(method, routeName, args) {
    let result, error;
    let query = '/api/lobby/' + routeName;

    await axios.post(query, args,{headers: {
        'Authorization' : getAuthToken()
        }})
        .then((res) => {
            result = res
        })
        .catch((res) => {
            error = res.response.data.message
        })

    return {result: result, error: error}
}
