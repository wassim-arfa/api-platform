import React from 'react';
import jwt from 'jsonwebtoken';
import Navbar from "../Navbar";

class Dashboard extends React.Component {

    constructor(props) 
    {
      super(props)

      this.state = {
          fullname: null,
          user_id: null
      }
    }

    componentWillMount()
    {
        if(!localStorage.getItem('token'))
        window.location.href = "login";
/*         var jwt = require("jsonwebtoken"); */
        var decode = jwt.decode(localStorage.getItem('token'));

        /// Redirect to login page if wrong token provided ///
        if(!decode)
        {
            localStorage.removeItem('token');
            window.location.href = "login";
        }
        
        /// Update state
        this.setState({
            fullname: decode.fname+' '+decode.lname,
            user_id: decode.id
        });


    }

    render() {          

        return (
            <div>
                <Navbar title={this.state.fullname} user_id={this.state.user_id}/>
                <h1 className="page-header" style={{marginTop: '2%', marginLeft: '20%', marginRight: '20%'}}>
                Welcome !</h1>
            </div>
        );
    }
}

export default (Dashboard);