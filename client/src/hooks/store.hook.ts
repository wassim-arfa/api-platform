import { createTypedHooks } from "easy-peasy";
import { StoreModel } from "../models/store.model";

export const {
    useStoreActions,
    useStoreState,
    useStoreDispatch,
    useStore,
} = createTypedHooks<StoreModel>();
