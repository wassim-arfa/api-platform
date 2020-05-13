import React from "react";
import { Route } from "react-router-dom";
import { List, Create, Update, Show, Dashboard, Login } from "../components/user/";

export default [
  <Route path="/users/create" component={Create} exact key="create" />,
  <Route path="/users/edit/:id" component={Update} exact key="update" />,
  <Route path="/users/show/:id" component={Show} exact key="show" />,
  <Route path="/users/" component={List} exact strict key="list" />,
  <Route path="/users/:page" component={List} exact strict key="page" />,
  <Route path="/login" component={Login} exact strict key="login" />,
  <Route path="/dashboard" component={Dashboard} exact strict key="dashboard" />,
];
