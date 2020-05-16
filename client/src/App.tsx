import React from "react";
import { Provider } from "react-redux";
import { Route, Switch, Router } from "react-router-dom";

import "./App.css";

// routes
import Welcome from "./Welcome";
import Login from "./pages/login";
import { history, store } from "./store";

function App() {
    return (
        <Provider store={store}>
            <Router history={history}>
                <Switch>
                    <Route
                        path="/"
                        component={Welcome}
                        strict={true}
                        exact={true}
                    />
                    <Route path="/login" component={Login} exact key="create" />
                    ,{/* Add your routes here */}
                    <Route render={() => <h1>Not Found</h1>} />
                </Switch>
            </Router>
        </Provider>
    );
}

export default App;
