import { createStore, EasyPeasyConfig } from "easy-peasy";

import { storeModel, StoreModel } from "./store.model";
import { config } from "./storeConfig";

const store = createStore<StoreModel, EasyPeasyConfig>(storeModel, config);

// Wrapping dev only code like this normally gets stripped out by bundlers
// such as Webpack when creating a production build.
if (process.env.NODE_ENV === "development") {
    if (module.hot) {
        module.hot.accept("./store.ts", () => {
            store.reconfigure(storeModel); // 👈 Here is the magic
        });
    }
}

// export const history = createReduxHistory(store);
export default store;
