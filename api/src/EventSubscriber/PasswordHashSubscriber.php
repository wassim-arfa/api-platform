<?php


namespace App\EventSubscriber;


use ApiPlatform\Core\EventListener\EventPriorities;
use App\Entity\User;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\GetResponseForControllerResultEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class PasswordHashSubscriber implements  EventSubscriberInterface
{
    private $passwordEncoder;
    public function __construct(UserPasswordEncoderInterface  $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    /**
     * @return array The event names to listen to
     */
    public static function getSubscribedEvents()
    {
        // TODO: Implement getSubscribedEvents() method.
        return [
            KernelEvents::VIEW => ['HashPassword',EventPriorities::PRE_WRITE]
        ];
    }

    public function HashPassword(GetResponseForControllerResultEvent $event)
    {
        $user = $event->getControllerResult();
        $method = $event->getRequest()->getMethod();
        if (! $user instanceof User || $method !== Request::METHOD_POST)
        {return;}

        $user->setPassword(
            $this->passwordEncoder->encodePassword($user, $user->getPassword())
        );
    }


}
