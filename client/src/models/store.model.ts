import { reducer } from "easy-peasy";

import { routerReducer } from "../root/store/reduxHistoryContext";

// models
import { userModel, UserModel } from "./user.model";

export interface StoreModel {
    router: any;
    user: UserModel;
}

export const storeModel: StoreModel = {
    router: reducer(routerReducer),
    user: userModel,
};
