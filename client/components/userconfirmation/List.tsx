import { FunctionComponent } from 'react';
import { ListItem } from './ListItem';
import { UserConfirmation } from '../../interfaces/UserConfirmation';

interface Props {
  user_confirmations: UserConfirmation[];
}

export const List: FunctionComponent<Props> = ({ user_confirmations }) => (
  <div>
    <h1>UserConfirmation List</h1>
    <table className="table table-responsive table-striped table-hover">
      <thead>
        <tr>
          <th>id</th>
          <th>confirmationToken</th>
          <th/>
        </tr>
      </thead>
      <tbody>
        { user_confirmations && user_confirmations.length && user_confirmations.map(userconfirmation => (
          <ListItem key={ userconfirmation['@id'] } userconfirmation={ userconfirmation } />
        ))}
      </tbody>
    </table>
  </div>
);
