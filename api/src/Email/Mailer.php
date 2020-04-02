<?php

namespace App\Email;

use App\Entity\User;
use Swift_Message;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class Mailer extends AbstractController
{
    /**
     * @var \Swift_Mailer
     */
    private $mailer;

    public function __construct(
        \Swift_Mailer $mailer
    )
    {
        $this->mailer = $mailer;
    }

    public function sendConfirmationEmail(User $user)
    {
        $body = $this->render('email/confirmation.html.twig', ['user' => $user]);

        $message = (new Swift_Message('Please confirm your account!'))
            ->setFrom('api-platform@api.com')
            ->setTo($user->getEmail())
            ->setBody($body, 'text/html');

        $this->mailer->send($message);
    }
}