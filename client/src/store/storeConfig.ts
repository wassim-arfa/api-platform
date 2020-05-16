import { EasyPeasyConfig } from "easy-peasy";
import { routerMiddleware } from "./reduxHistoryContext";

export const config: EasyPeasyConfig = {
    middleware: [routerMiddleware],
};
