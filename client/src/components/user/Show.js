import React, { Component } from 'react';
import { connect } from 'react-redux';
import { Link, Redirect } from 'react-router-dom';
import PropTypes from 'prop-types';
import { retrieve, reset } from '../../actions/user/show';
import { del } from '../../actions/user/delete';

class Show extends Component {
  static propTypes = {
    retrieved: PropTypes.object,
    loading: PropTypes.bool.isRequired,
    error: PropTypes.string,
    eventSource: PropTypes.instanceOf(EventSource),
    retrieve: PropTypes.func.isRequired,
    reset: PropTypes.func.isRequired,
    deleteError: PropTypes.string,
    deleteLoading: PropTypes.bool.isRequired,
    deleted: PropTypes.object,
    del: PropTypes.func.isRequired
  };

  componentDidMount() {
    this.props.retrieve(decodeURIComponent(this.props.match.params.id));
  }

  componentWillUnmount() {
    this.props.reset(this.props.eventSource);
  }

  del = () => {
    if (window.confirm('Are you sure you want to delete this item?'))
      this.props.del(this.props.retrieved);
  };

  render() {
    if (this.props.deleted) return <Redirect to=".." />;

    const item = this.props.retrieved;

    return (
      <div>
        <h1>Show {item && item['@id']}</h1>

        {this.props.loading && (
          <div className="alert alert-info" role="status">
            Loading...
          </div>
        )}
        {this.props.error && (
          <div className="alert alert-danger" role="alert">
            <span className="fa fa-exclamation-triangle" aria-hidden="true" />{' '}
            {this.props.error}
          </div>
        )}
        {this.props.deleteError && (
          <div className="alert alert-danger" role="alert">
            <span className="fa fa-exclamation-triangle" aria-hidden="true" />{' '}
            {this.props.deleteError}
          </div>
        )}

        {item && (
          <table className="table table-responsive table-striped table-hover">
            <thead>
              <tr>
                <th>Field</th>
                <th>Value</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <th scope="row">username</th>
                <td>{item['username']}</td>
              </tr>
              <tr>
                <th scope="row">roles</th>
                <td>{item['roles']}</td>
              </tr>
              <tr>
                <th scope="row">password</th>
                <td>{item['password']}</td>
              </tr>
              <tr>
                <th scope="row">salt</th>
                <td>{item['salt']}</td>
              </tr>
              <tr>
                <th scope="row">createdAt</th>
                <td>{item['createdAt']}</td>
              </tr>
              <tr>
                <th scope="row">updatedAt</th>
                <td>{item['updatedAt']}</td>
              </tr>
              <tr>
                <th scope="row">passwordChangeDate</th>
                <td>{item['passwordChangeDate']}</td>
              </tr>
              <tr>
                <th scope="row">newPassword</th>
                <td>{item['newPassword']}</td>
              </tr>
              <tr>
                <th scope="row">newRetypedPassword</th>
                <td>{item['newRetypedPassword']}</td>
              </tr>
              <tr>
                <th scope="row">oldPassword</th>
                <td>{item['oldPassword']}</td>
              </tr>
              <tr>
                <th scope="row">fname</th>
                <td>{item['fname']}</td>
              </tr>
              <tr>
                <th scope="row">lname</th>
                <td>{item['lname']}</td>
              </tr>
              <tr>
                <th scope="row">email</th>
                <td>{item['email']}</td>
              </tr>
              <tr>
                <th scope="row">address</th>
                <td>{item['address']}</td>
              </tr>
              <tr>
                <th scope="row">bio</th>
                <td>{item['bio']}</td>
              </tr>
              <tr>
                <th scope="row">mobile</th>
                <td>{item['mobile']}</td>
              </tr>
              <tr>
                <th scope="row">landline</th>
                <td>{item['landline']}</td>
              </tr>
              <tr>
                <th scope="row">enabled</th>
                <td>{item['enabled']}</td>
              </tr>
              <tr>
                <th scope="row">confirmationToken</th>
                <td>{item['confirmationToken']}</td>
              </tr>
            </tbody>
          </table>
        )}
        <Link to=".." className="btn btn-primary">
          Back to list
        </Link>
        {item && (
          <Link to={`/users/edit/${encodeURIComponent(item['@id'])}`}>
            <button className="btn btn-warning">Edit</button>
          </Link>
        )}
        <button onClick={this.del} className="btn btn-danger">
          Delete
        </button>
      </div>
    );
  }

  renderLinks = (type, items) => {
    if (Array.isArray(items)) {
      return items.map((item, i) => (
        <div key={i}>{this.renderLinks(type, item)}</div>
      ));
    }

    return (
      <Link to={`../../${type}/show/${encodeURIComponent(items)}`}>
        {items}
      </Link>
    );
  };
}

const mapStateToProps = state => ({
  retrieved: state.user.show.retrieved,
  error: state.user.show.error,
  loading: state.user.show.loading,
  eventSource: state.user.show.eventSource,
  deleteError: state.user.del.error,
  deleteLoading: state.user.del.loading,
  deleted: state.user.del.deleted
});

const mapDispatchToProps = dispatch => ({
  retrieve: id => dispatch(retrieve(id)),
  del: item => dispatch(del(item)),
  reset: eventSource => dispatch(reset(eventSource))
});

export default connect(mapStateToProps, mapDispatchToProps)(Show);
