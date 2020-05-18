import React from "react";
import { StoreProvider } from "easy-peasy";
import { Route, Switch, Router } from "react-router-dom";
import { push } from "redux-first-history";
import "./App.css";

import { history, store } from "../store";
// routes
import user from "../routes/user";

import { withAppLayout } from "../../components/layouts";
import Welcome from "../../pages/welcome";
import Dev from "../../pages/dev";

declare global {
    interface Window {
        navigate: any;
    }
}
// tslint:disable-next-line
window.navigate = (t: any) => store.dispatch(push(t));

const App = () => {
    return (
        <StoreProvider store={store}>
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
        </StoreProvider>
    );
};

export default App;
