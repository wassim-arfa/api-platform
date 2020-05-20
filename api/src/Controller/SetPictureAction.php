<?php


namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use ApiPlatform\Core\Validator\ValidatorInterface;
use App\Entity\Image;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;


class SetPictureAction
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
        $image = $this->entityManager
        ->getRepository(Image::class)
        ->findBy(
            [
                "id"=>$data->getPic(),
                "owner"=>$data->getId(),
                "deletedAt"=>null
            ]
        );


        if(is_integer($data->getPic()) && $image)
        {
            /*  $this->validator->validate($data); */
            $data->setPicture('/images/' . $data->getPic());
            /*  $this->entityManager->flush($data); */
        }
        else
        throw new BadRequestHttpException('You cant set this picture as profile picture');

        return $data;

    }

}
