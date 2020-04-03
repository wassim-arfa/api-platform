import React, { Component } from 'react';
import { Field, reduxForm } from 'redux-form';
import PropTypes from 'prop-types';

class Form extends Component {
  static propTypes = {
    handleSubmit: PropTypes.func.isRequired,
    error: PropTypes.string
  };

  renderField = data => {
    data.input.className = 'form-control';

    const isInvalid = data.meta.touched && !!data.meta.error;
    if (isInvalid) {
      data.input.className += ' is-invalid';
      data.input['aria-invalid'] = true;
    }

    if (this.props.error && data.meta.touched && !data.meta.error) {
      data.input.className += ' is-valid';
    }

    return (
      <div className={`form-group`}>
        <label
          htmlFor={`user_${data.input.name}`}
          className="form-control-label"
        >
          {data.input.name}
        </label>
        <input
          {...data.input}
          type={data.type}
          step={data.step}
          required={data.required}
          placeholder={data.placeholder}
          id={`user_${data.input.name}`}
        />
        {isInvalid && <div className="invalid-feedback">{data.meta.error}</div>}
      </div>
    );
  };

  render() {
    return (
      <form onSubmit={this.props.handleSubmit}>
        <Field
          component={this.renderField}
          name="username"
          type="text"
          placeholder=""
          required={true}
        />
{/*         <Field
          component={this.renderField}
          name="roles"
          type="text"
          placeholder=""
        /> */}
        <Field
          component={this.renderField}
          name="password"
          type="text"
          placeholder="The hashed password"
          required={true}
        />
{/*         <Field
          component={this.renderField}
          name="createdAt"
          type="dateTime"
          placeholder=""
        />
        <Field
          component={this.renderField}
          name="updatedAt"
          type="dateTime"
          placeholder=""
        />
        <Field
          component={this.renderField}
          name="passwordChangeDate"
          type="number"
          placeholder=""
          normalize={v => parseFloat(v)}
        />
        <Field
          component={this.renderField}
          name="newPassword"
          type="text"
          placeholder=""
        />
        <Field
          component={this.renderField}
          name="newRetypedPassword"
          type="text"
          placeholder=""
        /> */}
        <Field
          component={this.renderField}
          name="fname"
          type="text"
          placeholder=""
          required={true}
        />
        <Field
          component={this.renderField}
          name="lname"
          type="text"
          placeholder=""
          required={true}
        />
        <Field
          component={this.renderField}
          name="email"
          type="email"
          placeholder=""
          required={true}
        />
        <Field
          component={this.renderField}
          name="address"
          type="text"
          placeholder=""
        />
        <Field
          component={this.renderField}
          name="bio"
          type="text"
          placeholder=""
        />
        <Field
          component={this.renderField}
          name="mobile"
          type="text"
          placeholder=""
        />
        <Field
          component={this.renderField}
          name="landline"
          type="text"
          placeholder=""
        />
{/*         <Field
          component={this.renderField}
          name="enabled"
          type="checkbox"
          placeholder=""
        />
        <Field
          component={this.renderField}
          name="confirmationToken"
          type="text"
          placeholder=""
        /> */}

        <button type="submit" className="btn btn-success">
          Submit
        </button>
      </form>
    );
  }
}

export default reduxForm({
  form: 'user',
  enableReinitialize: true,
  keepDirtyOnReinitialize: true
})(Form);
