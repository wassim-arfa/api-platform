import { NextComponentType, NextPageContext } from 'next';
import { Show } from '../../components/userconfirmation/Show';
import { UserConfirmation } from '../../interfaces/UserConfirmation';
import { fetch } from '../../utils/dataAccess';

interface Props {
  userconfirmation: UserConfirmation;
};

const Page: NextComponentType<NextPageContext, Props, Props> = ({ userconfirmation }) => {
  return (
    <Show userconfirmation={ userconfirmation }/>
  );
};

Page.getInitialProps = async ({ asPath }: NextPageContext) => {
  const userconfirmation = await fetch(asPath);

  return { userconfirmation };
};

export default Page;
