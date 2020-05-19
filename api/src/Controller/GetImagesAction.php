<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use ApiPlatform\Core\Validator\ValidatorInterface;
use App\Entity\Image;
use Symfony\Component\Security\Core\Security;


class GetImagesAction
{
    /**
     * @var ValidatorInterface
     */
    private $validator;
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;
    /**
     * @var Security
     */
    private $security;

    /**
     * GetImagesAction constructor.
     * @param ValidatorInterface $validator
     * @param EntityManagerInterface $entityManager
     * @param Security $security
     */
    public function __construct(ValidatorInterface $validator, EntityManagerInterface $entityManager, Security $security)
    {
        $this->validator = $validator;
        $this->entityManager = $entityManager;
        $this->security = $security;
    }


    public function __invoke(User $data)
    {
        if($data === $this->security->getUser())
        {
            $images = $this->entityManager
                ->getRepository(Image::class)
                ->findBy(
                    [
                        "owner"=>$data->getId(),
                        "deletedAt"=>null
                    ]
                );
        }
        else
        {
            $images = $this->entityManager
                ->getRepository(Image::class)
                ->findBy(
                    [
                        "owner"=>$data->getId(),
                        "private"=>false,
                        "deletedAt"=>null
                    ]
                );
        }

        return $images;
    }

}
