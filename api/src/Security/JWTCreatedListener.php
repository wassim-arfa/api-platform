<?php

namespace App\Security;

use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTCreatedEvent;

class JWTCreatedListener
{
    /**
     * Adds additional data to the generated JWT
     *
     * @param JWTCreatedEvent $event
     *
     * @return void
     */
    public function onJWTCreated(JWTCreatedEvent $event)
    {
        /** @var $user \App\Entity\User */
        $user = $event->getUser();

        // add id to existing event data (roles & username)
        $payload = $event->getData();
        $payload['id'] = $user->getId();
        $payload['fname'] = $user->getFname();
        $payload['lname'] = $user->getLname();

        $event->setData($payload);
    }
} 