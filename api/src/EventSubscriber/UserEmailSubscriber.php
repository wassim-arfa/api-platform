<?php

namespace App\EventSubscriber;

use ApiPlatform\Core\EventListener\EventPriorities;
use App\Entity\UserConfirmation;
use App\Security\UserConfirmationService;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\GetResponseForControllerResultEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use App\Security\UserRecoverService;

class UserEmailSubscriber implements EventSubscriberInterface
{

    private $UserRecoverService;

    public function __construct(UserRecoverService $UserRecoverService) 
    {
        $this->UserRecoverService = $UserRecoverService;
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::VIEW => [
                'recoverPassword',
                EventPriorities::POST_VALIDATE,
            ],
        ];
    }

    public function recoverPassword(GetResponseForControllerResultEvent $event)
    {
        $request = $event->getRequest();

        if ('api_user_emails_post_collection' !==
            $request->get('_route')) {
            return;
        }

        /** @var UserConfirmation $confirmationToken */
        $email = $event->getControllerResult()->email;

/*         var_dump($email); */
        $this->UserRecoverService->recoverPassword($email);

        $event->setResponse(new JsonResponse(null, Response::HTTP_OK));
    }
}