import React from "react";
import { Provider } from "react-redux";
import { Route, Switch, Router } from "react-router-dom";
import { push } from "redux-first-history";

import "./App.css";

import { history, store } from "../store";
// routes
import withAppLayout from "../../layouts/appLyout";
import user from "../routes/user";

import Welcome from "../../pages/welcome";
import Dev from "../../pages/dev";

export {};
declare global {
    interface Window {
        navigate: any;
    }
}
// tslint:disable-next-line
window.navigate = (t: any) => store.dispatch(push(t));

function App() {
    return (
        <Provider store={store}>
            <Router history={history}>
                <Switch>
                    <Route
                        path="/dev"
                        component={withAppLayout(Dev)}
                        exact
                        key="dev"
                    />
                    <Route
                        path="/welcome"
                        component={withAppLayout(Welcome)}
                        exact
                        key="welcome"
                    />
                    ,{/* Add your routes here */},{user}
                    <Route render={() => <h1>Not Found</h1>} />
                </Switch>
            </Router>
        </Provider>
    );
}

export default App;
