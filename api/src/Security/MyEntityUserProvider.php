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

        if (!isset($this->properties[$resourceOwnerName])) {
            throw new \RuntimeException(sprintf("No property defined for entity for resource owner '%s'.", $resourceOwnerName));
        }

        $serviceName = $response->getResourceOwner()->getName();
        $setterId = 'set'. ucfirst($serviceName) . 'ID';
        $setterAccessToken = 'set'. ucfirst($serviceName) . 'AccessToken';

        $username = $response->getUsername();
        // find user by social network email
        $email = $response->getEmail();
        $user = $this->em->getRepository(User::class)->findOneBy(["email" => $email]);

        if ($user === null) {
            // TODO: Create the user
            $usr = new User();
            $usr->setUsername($username);
            $usr->setEmail($email);
            $usr->setPassword($username);
            $usr->setFname($response->getFirstName()?$response->getFirstName():"");
            $usr->setLname($response->getLastName()?$response->getLastName():"");
            $usr->setPicture($response->getProfilePicture());
            $usr->setAgreement(true);
            $usr->$setterId($username);
            $usr->$setterAccessToken($response->getAccessToken());
            $usr->setEnabled(true);
            $this->em->persist($usr);
            $this->em->flush();
            return $usr;
        }
        else
        {
            //if user exists update id & access token
            $user->$setterId($username);
            $user->$setterAccessToken($response->getAccessToken());
            // if user have no picture set picture from social network
            if (!$user->getPicture())
            $user->setPicture($response->getProfilePicture());
            $this->em->persist($user);
            $this->em->flush();
            return $user;
        }


    }

    /**
     * Connects the response to the user object.
     *
     * @param UserInterface $user The user object
     * @param UserResponseInterface $response The oauth response
     */
    public function connect(UserInterface $user, UserResponseInterface $response)
    {

    }
}
