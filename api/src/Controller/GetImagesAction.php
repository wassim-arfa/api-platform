<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use ApiPlatform\Core\Validator\ValidatorInterface;
use App\Entity\Image;


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


    public function __construct(
        EntityManagerInterface $entityManager,
        ValidatorInterface $validator
        )
    {
        $this->validator = $validator;
        $this->entityManager = $entityManager;
    }

    public function __invoke(User $data)
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

        return $images;

    }

}
