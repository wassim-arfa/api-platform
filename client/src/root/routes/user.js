import React from "react";
import { Route } from "react-router-dom";

import withCenterLayout from "../../layouts/centerLayout";
import Login from "../../pages/login";
import Register from "../../pages/register";

export default [
  <Route
    path="/login"
    component={withCenterLayout(Login)}
    exact
    key="create"
  />,
  <Route
    path="/register"
    component={withCenterLayout(Register)}
    exact
    key="create"
  />,
];
