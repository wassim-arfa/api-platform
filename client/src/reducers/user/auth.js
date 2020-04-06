import { combineReducers } from 'redux';

export function error(state = null, action) {
  switch (action.type) {
    case 'AUTH_ERROR':
      return action.error;

    default:
      return state;
  }
}

export function loading(state = false, action) {
  switch (action.type) {
    case 'AUTH_LOADING':
      return action.loading;

    default:
      return state;
  }
}
const initialState = localStorage.getItem('token')? true : false;
export function loggedIn(state = initialState, action) {
  switch (action.type) {
    case 'AUTH_SUCCESS':
      return action.login;

    default:
      return state;
  }
}

export default combineReducers({ error, loading, loggedIn });