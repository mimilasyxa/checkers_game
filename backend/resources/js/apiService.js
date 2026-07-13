import axios from 'axios';
export async function makeApiCall(method, routeName, args) {
    let query = '/api/broadcast/' + routeName;

    return await axios.post(query, {args})
        .then((res) => {
            return res
        })
}
