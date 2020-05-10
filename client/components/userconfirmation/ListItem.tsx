import { FunctionComponent } from 'react';
import { UserConfirmation } from '../../interfaces/UserConfirmation';
import { ReferenceLinks } from '../common/ReferenceLinks';

interface Props {
  userconfirmation: UserConfirmation
}

export const ListItem: FunctionComponent<Props> = ({ userconfirmation }: Props) => (
  <tr>
    <th scope="row"><ReferenceLinks items={ userconfirmation['@id'] } type="userconfirmation" /></th>
    <td>{ userconfirmation['confirmationToken'] }</td>
    <td><ReferenceLinks items={ userconfirmation['@id'] } type="userconfirmation" useIcon={true} /></td>
  </tr>
);
