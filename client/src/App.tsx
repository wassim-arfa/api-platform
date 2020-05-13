import React from "react";
import { createStore, combineReducers, applyMiddleware } from "redux";
import { composeWithDevTools } from "redux-devtools-extension";
import { Provider } from "react-redux";
import thunk from "redux-thunk";
import { reducer as form } from "redux-form";
import { Route, Switch } from "react-router-dom";
import createBrowserHistory from "history/createBrowserHistory";
import {
    ConnectedRouter,
    connectRouter,
    routerMiddleware,
} from "connected-react-router";
import "./App.css";

// reducers
import user from "./reducers/user/";

// routes
import Welcome from "./Welcome";
import userRoutes from "./routes/user";

const history = createBrowserHistory();
const store = createStore(
    combineReducers({
        router: connectRouter(history),
        form,
        /* Add your reducers here */
        user,
    }),
    composeWithDevTools(applyMiddleware(routerMiddleware(history), thunk))
);

function App() {
    return (
        <Provider store={store}>
            <ConnectedRouter history={history}>
                <Switch>
                    <Route
                        path="/"
                        component={Welcome}
                        strict={true}
                        exact={true}
                    />
                    {/* Add your routes here */}
                    {userRoutes}
                    <Route render={() => <h1>Not Found</h1>} />
                </Switch>
            </ConnectedRouter>
        </Provider>
    );
}

export default App;
