import { FunctionComponent } from 'react';
import Link from 'next/link';
import { ReferenceLinks } from '../common/ReferenceLinks';
import { User } from '../../interfaces/User';

interface Props {
  user: User;
}

export const Show: FunctionComponent<Props> = ({ user }) => (
  <div>
    <h1>Show { user['@id'] }</h1>
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
          <td>{ user['username'] }</td>
        </tr>
        <tr>
          <th scope="row">roles</th>
          <td>{ user['roles'] }</td>
        </tr>
        <tr>
          <th scope="row">password</th>
          <td>{ user['password'] }</td>
        </tr>
        <tr>
          <th scope="row">salt</th>
          <td>{ user['salt'] }</td>
        </tr>
        <tr>
          <th scope="row">createdAt</th>
          <td>{ user['createdAt'] }</td>
        </tr>
        <tr>
          <th scope="row">updatedAt</th>
          <td>{ user['updatedAt'] }</td>
        </tr>
        <tr>
          <th scope="row">passwordChangeDate</th>
          <td>{ user['passwordChangeDate'] }</td>
        </tr>
        <tr>
          <th scope="row">newPassword</th>
          <td>{ user['newPassword'] }</td>
        </tr>
        <tr>
          <th scope="row">newRetypedPassword</th>
          <td>{ user['newRetypedPassword'] }</td>
        </tr>
        <tr>
          <th scope="row">oldPassword</th>
          <td>{ user['oldPassword'] }</td>
        </tr>
        <tr>
          <th scope="row">fname</th>
          <td>{ user['fname'] }</td>
        </tr>
        <tr>
          <th scope="row">lname</th>
          <td>{ user['lname'] }</td>
        </tr>
        <tr>
          <th scope="row">email</th>
          <td>{ user['email'] }</td>
        </tr>
        <tr>
          <th scope="row">address</th>
          <td>{ user['address'] }</td>
        </tr>
        <tr>
          <th scope="row">bio</th>
          <td>{ user['bio'] }</td>
        </tr>
        <tr>
          <th scope="row">mobile</th>
          <td>{ user['mobile'] }</td>
        </tr>
        <tr>
          <th scope="row">landline</th>
          <td>{ user['landline'] }</td>
        </tr>
        <tr>
          <th scope="row">enabled</th>
          <td>{ user['enabled'] }</td>
        </tr>
        <tr>
          <th scope="row">confirmationToken</th>
          <td>{ user['confirmationToken'] }</td>
        </tr>
      </tbody>
    </table>
    <Link href="/users"><a className="btn btn-primary">
      Back to list
    </a></Link>
  </div>
);
