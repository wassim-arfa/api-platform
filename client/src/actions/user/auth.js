import axios from 'axios';
const SERVER_URL = "https://localhost:8443";

export function error(error) {
  return { type: 'AUTH_ERROR', error };
}

export function loading(loading) {
  return { type: 'AUTH_LOADING', loading };
}

export function success(login) {
  return { type: 'AUTH_SUCCESS', login };
}

export function login(values) {
  return dispatch => {
        dispatch(reset());
        dispatch(loading(true));
        axios.post(`${SERVER_URL}/auth`,values)
        .then((response) => {console.log(response.data)
             localStorage.setItem('token', response.data.token)
             window.location.href =`../dashboard`;
             dispatch(loading(false));
             dispatch(success(response));
            })
        .catch(function(e) {
            dispatch(loading(false));
            dispatch(error(e.message));             
              });
}}

export function reset() {
  return dispatch => {
    dispatch(loading(false));
    dispatch(error(null));
  };
}