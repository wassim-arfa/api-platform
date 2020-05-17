import { Action, action, Thunk, thunk } from "easy-peasy";

import { InjectionModel } from "./injection.model";
import { User } from "../interfaces/user";
import { UserRegister } from "../interfaces/user.register";
import { Auth } from "../interfaces/auth";
import { Token } from "../interfaces/token";

export interface UserModel {
    user: User;
    savedUser: Action<UserModel, User>;
    register: Thunk<UserModel, UserRegister, InjectionModel>;
    login: Thunk<UserModel, Auth, InjectionModel>;
    savedToken: Action<UserModel, Token>;
}

export const userModel: UserModel = {
    user: {
        email: "",
        fname: "",
        lname: "",
        username: "",
    },
    savedUser: action((state, payload: User) => {
        state.user = payload;
    }),
    register: thunk(async (actions, payload: UserRegister, { injections }) => {
        const user: User = await injections.user.register(payload);
        actions.savedUser(user);
    }),
    savedToken: action((state, payload: Token) => {
        localStorage.setItem("token", payload.token);
    }),
    login: thunk(async (actions, payload: Auth, { injections }) => {
        const token: Token = await injections.user.login(payload);
        actions.savedToken(token);
    }),
};
