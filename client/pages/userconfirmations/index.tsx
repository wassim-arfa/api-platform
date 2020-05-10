import { NextComponentType, NextPageContext } from 'next';
import { List } from '../../components/userconfirmation/List';
import { PagedCollection } from '../../interfaces/Collection';
import { UserConfirmation } from '../../interfaces/UserConfirmation';
import { fetch } from '../../utils/dataAccess';

interface Props {
  collection: PagedCollection<UserConfirmation>;
}

const Page: NextComponentType<NextPageContext, Props, Props> = ({collection}) => (
  <List user_confirmations={collection['hydra:member'] || []}/>
);

Page.getInitialProps = async () => {
  const collection = await fetch('/user_confirmations');

  return {collection};
};

export default Page;
