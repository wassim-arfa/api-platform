import React from "react";

import classenames from "./CenterLayout.module.css";

const withCenterLayout = (Component) => {
    return class CenterLayout extends React.Component {
        render() {
            return (
                <div className={classenames.center}>
                    <Component {...this.props} />
                </div>
            );
        }
    };
};

export default withCenterLayout;
