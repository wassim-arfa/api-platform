import { EasyPeasyConfig } from "easy-peasy";

import { routerMiddleware } from "./reduxHistoryContext";
import { injectionModel } from "./../../models/injection.model";

export const config: EasyPeasyConfig = {
    middleware: [routerMiddleware],
    injections: injectionModel,
};
