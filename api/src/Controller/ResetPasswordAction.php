<?php


namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use ApiPlatform\Core\Validator\ValidatorInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;


class ResetPasswordAction
{

    private $userPasswordEncoder;

    /**
     * @var JWTTokenManagerInterface
     */
    private $tokenManager;
    /**
     * @var ValidatorInterface
     */
    private $validator;
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;


    public function __construct(
        EntityManagerInterface $entityManager,
        ValidatorInterface $validator,
        UserPasswordEncoderInterface $userPasswordEncoder,
        JWTTokenManagerInterface $tokenManager)
    {
        $this->userPasswordEncoder = $userPasswordEncoder;
        $this->tokenManager = $tokenManager;
        $this->validator = $validator;
        $this->entityManager = $entityManager;
    }

    public function __invoke(User $data)
    {
        $this->validator->validate($data);
        $data->setPassword($this->userPasswordEncoder->encodePassword($data, $data->getNewPassword()));
        $data->setPasswordChangeDate(time());
        $this->entityManager->flush($data);
        $token = $this->tokenManager->create($data);
        return new JsonResponse(['token' => $token]);
//        return $data;
    }

}