import { FunctionComponent } from 'react';
import { ListItem } from './ListItem';
import { User } from '../../interfaces/User';

interface Props {
  users: User[];
}

export const List: FunctionComponent<Props> = ({ users }) => (
  <div>
    <h1>User List</h1>
    <table className="table table-responsive table-striped table-hover">
      <thead>
        <tr>
          <th>id</th>
          <th>username</th>
          <th>roles</th>
          <th>password</th>
          <th>salt</th>
          <th>createdAt</th>
          <th>updatedAt</th>
          <th>passwordChangeDate</th>
          <th>newPassword</th>
          <th>newRetypedPassword</th>
          <th>oldPassword</th>
          <th>fname</th>
          <th>lname</th>
          <th>email</th>
          <th>address</th>
          <th>bio</th>
          <th>mobile</th>
          <th>landline</th>
          <th>enabled</th>
          <th>confirmationToken</th>
          <th/>
        </tr>
      </thead>
      <tbody>
        { users && users.length && users.map(user => (
          <ListItem key={ user['@id'] } user={ user } />
        ))}
      </tbody>
    </table>
  </div>
);
