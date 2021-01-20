// @flow 
import * as React from 'react';
import {Switch, Route} from "react-router-dom";
import routes from "./index";


const AppRouter = () => {

    return (
        <Switch>
            {
                routes.map((route, key) => (
                    <Route
                        path={route.path}
                        exact={route.exact}
                        component={route.component}
                        key={key}
                    />
                ))
            }
        </Switch>
    );
};

export default AppRouter

