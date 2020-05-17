import { Action, action, Thunk, thunk } from "easy-peasy";

import { InjectionModel } from "./injection.model";
import { User } from "../interfaces/user";
import { UserRegister } from "../interfaces/user.register";

export interface UserModel {
    user: User;
    savedUser: Action<UserModel, User>;
    register: Thunk<UserModel, UserRegister, InjectionModel>;
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
};
