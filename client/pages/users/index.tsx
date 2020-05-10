import { NextComponentType, NextPageContext } from "next";
import { List } from "../../components/user/List";
import { PagedCollection } from "../../interfaces/Collection";
import { User } from "../../interfaces/User";
import { fetch } from "../../utils/dataAccess";

interface Props {
    collection: PagedCollection<User>;
}

const Page: NextComponentType<NextPageContext, Props, Props> = ({
    collection,
}) => <List users={collection["hydra:member"] || []} />;

Page.getInitialProps = async () => {
    const collection = await fetch("/users");

    return { collection };
};

export default Page;
