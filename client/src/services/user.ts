import { USERS, AUTH, API_RESET_PASSWORD } from "./../constants/api";
import { UserRegister } from "../interfaces/user.register";
import { User } from "../interfaces/user";
import { Auth } from "../interfaces/auth";
import { Token } from "../interfaces/token";
import { UserReset } from "../interfaces/user.reset";
import axiosInstance from "../config/axios";

export const register = async (user: UserRegister): Promise<User> => {
    console.log("user: ", user);
    const { data } = await axiosInstance.post(`${USERS}`, user);
    return data;
};

export const login = async (auth: Auth): Promise<Token> => {
    const { data } = await axiosInstance.post(`${AUTH}`, auth);
    return data;
};

export const changePassword = async (
    id: string,
    userReset: UserReset
): Promise<Token> => {
    const { data } = await axiosInstance.put(API_RESET_PASSWORD(id), userReset);
    return data;
};
