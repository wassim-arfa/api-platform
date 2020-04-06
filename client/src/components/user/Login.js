import React, { Component } from 'react';
import '../styles/Login.css';
import {connect} from "react-redux";
import { login, reset } from '../../actions/user/auth';

class Login  extends Component {

  constructor(props) 
  {
    super(props)

    this.state = {
        username: '',
        password: ''
    }
  }

     handleChange =(e)=> 
     {
        // check it out: we get the e.target.alias (which will be either "username" or "password")
        // and use it to target the key on our `state` object with the same name, using bracket syntax
        this.setState({[e.target.name]: e.target.value });
      }

      componentWillMount() {
       localStorage.getItem('token') && window.location.replace('/')
      }

      componentWillUnmount() {
        this.props.reset();
      }

      render()
      {

        return (
        <div>
         <div className="text-center">
         <form className="form-signin" onSubmit={(e)=>e.preventDefault()}>
         <img className="mb-4" src="https://getbootstrap.com/docs/4.0/assets/brand/bootstrap-solid.svg" width={72} height={72} />
         <h1 className="h3 mb-3 font-weight-normal">Please sign in</h1>
         <p>
         {this.props.error && (
          <span class="badge badge-warning">
            {this.props.error}
          </span>
          )}
         </p>
         <label htmlFor="inputUsername" className="sr-only">Username</label>
         <input name="username" onChange={this.handleChange} type="text" id="username" className="form-control" placeholder="Username" required autoFocus />
         <label htmlFor="inputPassword" className="sr-only">Password</label>
         <input name="password" onChange={this.handleChange} type="password" id="inputPassword" className="form-control" placeholder="Password" required />

         <button className="btn btn-lg btn-primary btn-block" type="submit" onClick={()=>this.props.login(this.state)}>
         {this.props.loading && (<span class="spinner-border spinner-border-lg" role="status" aria-hidden="true"></span>)}
         {' '}Sign in</button>
         <p className="mt-5 mb-3 text-muted">© 2019-2020</p>
         </form>
     </div> 
        </div>
        );
   }
};

const mapStateToProps = state => {
  const { error, loading } = state.user.auth;
  return { error, loading };
};
const mapDispatchToProps = (dispatch) => {
  return {
      login: (values) => dispatch(login(values)),
      reset: () => dispatch(reset())
  };
}

export default connect(mapStateToProps, mapDispatchToProps)(Login);