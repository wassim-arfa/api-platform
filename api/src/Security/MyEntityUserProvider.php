<?php

namespace App\Security;

use App\Entity\User;

use HWI\Bundle\OAuthBundle\Connect\AccountConnectorInterface;
use HWI\Bundle\OAuthBundle\OAuth\Response\UserResponseInterface;
use HWI\Bundle\OAuthBundle\Security\Core\User\EntityUserProvider;
use Symfony\Component\Security\Core\User\UserInterface;

class MyEntityUserProvider extends EntityUserProvider implements AccountConnectorInterface {

    public function loadUserByOAuthUserResponse(UserResponseInterface $response)
    {
        $resourceOwnerName = $response->getResourceOwner()->getName();
/*         var_dump($response->getFirstName());
        echo(nl2br("\n"));
        var_dump($response->getLastName());
        echo(nl2br("\n"));
        var_dump($response->getEmail());
        echo(nl2br("\n"));
        var_dump($response->getProfilePicture());die; */
        if (!isset($this->properties[$resourceOwnerName])) {
            throw new \RuntimeException(sprintf("No property defined for entity for resource owner '%s'.", $resourceOwnerName));
        }

        $serviceName = $response->getResourceOwner()->getName();
        $setterId = 'set'. ucfirst($serviceName) . 'ID';
        $setterAccessToken = 'set'. ucfirst($serviceName) . 'AccessToken';

        // unique integer
        $username = $response->getUsername();
        if (null === $user = $this->findUser(array($this->properties[$resourceOwnerName] => $username))) {
            // TODO: Create the user
            $user = new User();
            
            $user->setEmail($response->getEmail());
            $firstname = $response->getFirstName()?$response->getFirstName():'first_name';
            $lastname = $response->getLastName()?$response->getLastName():'last_name';
            $user->setFName($firstname);
            $user->setLName($lastname);
            $usr = explode("@", $response->getEmail());
            $user->setUsername(strtolower($usr[0]));
            $user->setPassword(strtolower($usr[0]));
            $user->setEnabled(true);

            $user->$setterId($username);
            $user->$setterAccessToken($response->getAccessToken());

            $this->em->persist($user);
            $this->em->flush();

            return $user;
        }
        //if user exists - go with the HWIOAuth way
        $user = parent::loadUserByOAuthUserResponse($response);
        $serviceName = $response->getResourceOwner()->getName();
        $setter = 'set' . ucfirst($serviceName) . 'AccessToken';

        //update access token
        $user->$setter($response->getAccessToken());
        return $user;
    }

    /**
     * Connects the response to the user object.
     *
     * @param UserInterface $user The user object
     * @param UserResponseInterface $response The oauth response
     */
    public function connect(UserInterface $user, UserResponseInterface $response)
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(sprintf('Expected an instance of App\Model\User, but got "%s".', get_class($user)));
        }
var_dump($this->getProperty($response));die;
        $property = $this->getProperty($response);
        $username = $response->getUsername();

        if (null !== $previousUser = $this->registry->getRepository(User::class)->findOneBy(array($property => $username))) {
            // 'disconnect' previously connected users
            $this->disconnect($previousUser, $response);
        }


        $serviceName = $response->getResourceOwner()->getName();
        $setter = 'set'. ucfirst($serviceName) . 'AccessToken';

        $user->$setter($response->getAccessToken());

        $this->updateUser($user, $response);
    }

    /**
     * ##STOLEN#
     * Gets the property for the response.
     *
     * @param UserResponseInterface $response
     *
     * @return string
     *
     * @throws \RuntimeException
     */
    protected function getProperty(UserResponseInterface $response)
    {
        $resourceOwnerName = $response->getResourceOwner()->getName();

        if (!isset($this->properties[$resourceOwnerName])) {
            throw new \RuntimeException(sprintf("No property defined for entity for resource owner '%s'.", $resourceOwnerName));
        }

        return $this->properties[$resourceOwnerName];
    }

    /**
     * Disconnects a user.
     *
     * @param UserInterface $user
     * @param UserResponseInterface $response
     * @throws \TypeError
     */
    public function disconnect(UserInterface $user, UserResponseInterface $response)
    {
        $property = $this->getProperty($response);
        $accessor = PropertyAccess::createPropertyAccessor();

        $accessor->setValue($user, $property, null);

        $this->updateUser($user, $response);
    }

    /**
     * Update the user and persist the changes to the database.
     * @param UserInterface $user
     * @param UserResponseInterface $response
     */
    private function updateUser(UserInterface $user, UserResponseInterface $response)
    {
        //$user->setEmail($response->getEmail());
        // TODO: Add more fields?!

        $this->em->persist($user);
        $this->em->flush();
    }
}