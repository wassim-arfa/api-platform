import { reducer } from "easy-peasy";

import { User } from "./../interfaces/user";
import { routerReducer } from "./reduxHistoryContext";

export interface StoreModel {
    router: any;
    user: User;
}

export const storeModel: StoreModel = {
    router: reducer(routerReducer),
    user: {
        email: "",
        fname: "",
        lname: "",
        password: "",
        username: "",
    },
};
