import { FunctionComponent } from 'react';
import { User } from '../../interfaces/User';
import { ReferenceLinks } from '../common/ReferenceLinks';

interface Props {
  user: User
}

export const ListItem: FunctionComponent<Props> = ({ user }: Props) => (
  <tr>
    <th scope="row"><ReferenceLinks items={ user['@id'] } type="user" /></th>
    <td>{ user['username'] }</td>
    <td>{ user['roles'] }</td>
    <td>{ user['password'] }</td>
    <td>{ user['salt'] }</td>
    <td>{ user['createdAt'] }</td>
    <td>{ user['updatedAt'] }</td>
    <td>{ user['passwordChangeDate'] }</td>
    <td>{ user['newPassword'] }</td>
    <td>{ user['newRetypedPassword'] }</td>
    <td>{ user['oldPassword'] }</td>
    <td>{ user['fname'] }</td>
    <td>{ user['lname'] }</td>
    <td>{ user['email'] }</td>
    <td>{ user['address'] }</td>
    <td>{ user['bio'] }</td>
    <td>{ user['mobile'] }</td>
    <td>{ user['landline'] }</td>
    <td>{ user['enabled'] }</td>
    <td>{ user['confirmationToken'] }</td>
    <td><ReferenceLinks items={ user['@id'] } type="user" useIcon={true} /></td>
  </tr>
);
