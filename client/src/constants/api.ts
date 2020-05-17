export const USERS = "users";
export const AUTH = "auth";
export const RESET_PASSWORD = "reset-password";

export const API_RESET_PASSWORD = (id: string) =>
    `${USERS}/${id}/${RESET_PASSWORD}`;
