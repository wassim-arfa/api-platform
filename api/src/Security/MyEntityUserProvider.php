<?php

namespace App\Security;

use App\Entity\User;

use Doctrine\Common\Persistence\ManagerRegistry;
use Gesdinet\JWTRefreshTokenBundle\Model\RefreshTokenManagerInterface;
use HWI\Bundle\OAuthBundle\OAuth\Response\UserResponseInterface;
use HWI\Bundle\OAuthBundle\Security\Core\User\EntityUserProvider;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class MyEntityUserProvider extends EntityUserProvider {

    /**
     * @var UserPasswordEncoderInterface
     */
    private $passwordEncoder;

    /**
     * @var JWTTokenManagerInterface
     */
    private $jwtManager;

    /**
     * @var RefreshTokenManagerInterface
     */
    private  $refreshToken;
    /**
     * Constructor.
     *
     * @param ManagerRegistry $registry    manager registry
     * @param string          $class       user entity class to load
     * @param array           $properties  Mapping of resource owners to properties
     * @param string          $managerName Optional name of the entity manager to use
     */
    public function __construct(ManagerRegistry $registry, $class, array $properties, $managerName = null ,UserPasswordEncoderInterface $passwordEncoder, JWTTokenManagerInterface $jwtManager, RefreshTokenManagerInterface $refreshToken)
    {
        parent::__construct($registry, $class, $properties, $managerName = null);
        $this->passwordEncoder = $passwordEncoder;
        $this->jwtManager = $jwtManager;
        $this->refreshToken = $refreshToken;
    }

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
            $usr->setPassword($this->passwordEncoder->encodePassword($usr, $username));
            $usr->setFname($response->getFirstName()?$response->getFirstName():"");
            $usr->setLname($response->getLastName()?$response->getLastName():"");
            $usr->setPicture($response->getProfilePicture());
            $usr->setAgreement(true);
            $usr->$setterId($username);
            $usr->$setterAccessToken($response->getAccessToken());
            $usr->setEnabled(true);
            $this->em->persist($usr);
            $this->em->flush();
            $token = $this->jwtManager->create($usr);
            $refresh_token = $this->refreshToken->getLastFromUsername($usr->getUsername())->getRefreshToken();
            dd(['token'=>$token, 'refresh_token'=>$refresh_token]);
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
            $token = $this->jwtManager->create($user);
            $refresh_token = $this->refreshToken->getLastFromUsername($user->getUsername())->getRefreshToken();
            dd(['token'=>$token, 'refresh_token'=>$refresh_token]);
        }
    }
}
