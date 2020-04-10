import React from 'react';

const Navbar = (props) => {

    const logout=()=>
    {
        localStorage.removeItem('token');
        window.location.href = "/login";
    }
    return (
        <div>

        <div className="d-flex flex-column flex-md-row align-items-center p-3 px-md-4 mb-3 bg-white border-bottom box-shadow">
        <h5 className="my-0 mr-md-auto font-weight-normal">{props.title}</h5>
        <nav className="my-2 my-md-0 mr-md-3">
        <a className="p-2 text-dark" href={`../users/edit/${encodeURIComponent("/users/"+props.user_id)}`}>Edit Profile</a>
        </nav>
        <a className="btn btn-outline-primary" href="#" onClick={()=>logout()}>Logout</a>
        </div>    
          
        </div>
    );
};

export default Navbar; 