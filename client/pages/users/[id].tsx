import { NextComponentType, NextPageContext } from 'next';
import { Show } from '../../components/user/Show';
import { User } from '../../interfaces/User';
import { fetch } from '../../utils/dataAccess';

interface Props {
  user: User;
};

const Page: NextComponentType<NextPageContext, Props, Props> = ({ user }) => {
  return (
    <Show user={ user }/>
  );
};

Page.getInitialProps = async ({ asPath }: NextPageContext) => {
  const user = await fetch(asPath);

  return { user };
};

export default Page;
