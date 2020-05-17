import * as userService from "../services/user";

export interface InjectionModel {
    user: typeof userService;
}

export const injectionModel: InjectionModel = {
    user: userService,
};
