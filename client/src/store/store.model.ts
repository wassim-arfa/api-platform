import { reducer } from "easy-peasy";

import { User } from "./../interfaces/user";

export interface StoreModel {
    //router: any
    user: User;
}

export const storeModel: StoreModel = {
    //router: ,
    user: {
        email: "",
        fname: "",
        lname: "",
        password: "",
        username: "",
    },
};
