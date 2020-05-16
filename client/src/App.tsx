import React from "react";
import { Provider, useDispatch } from "react-redux";
import { Route, Switch, Router } from "react-router-dom";
import { push } from "redux-first-history";

import "./App.css";

// routes
import Login from "./pages/login";
import Welcome from "./pages/welcome";
import { history, store } from "./store";

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
                    <Route path="/login" component={Login} exact key="create" />
                    <Route
                        path="/welcome"
                        component={Welcome}
                        exact
                        key="create"
                    />
                    ,{/* Add your routes here */}
                    <Route render={() => <h1>Not Found</h1>} />
                </Switch>
            </Router>
        </Provider>
    );
}

export default App;
