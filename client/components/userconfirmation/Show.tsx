import { FunctionComponent } from 'react';
import Link from 'next/link';
import { ReferenceLinks } from '../common/ReferenceLinks';
import { UserConfirmation } from '../../interfaces/UserConfirmation';

interface Props {
  userconfirmation: UserConfirmation;
}

export const Show: FunctionComponent<Props> = ({ userconfirmation }) => (
  <div>
    <h1>Show { userconfirmation['@id'] }</h1>
    <table className="table table-responsive table-striped table-hover">
      <thead>
      <tr>
        <th>Field</th>
        <th>Value</th>
      </tr>
      </thead>
      <tbody>
        <tr>
          <th scope="row">confirmationToken</th>
          <td>{ userconfirmation['confirmationToken'] }</td>
        </tr>
      </tbody>
    </table>
    <Link href="/user_confirmations"><a className="btn btn-primary">
      Back to list
    </a></Link>
  </div>
);
