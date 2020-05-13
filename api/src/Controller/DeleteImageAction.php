<?php


namespace App\Controller;

use App\Entity\Image;
use Doctrine\ORM\EntityManagerInterface;
use ApiPlatform\Core\Validator\ValidatorInterface;




class DeleteImageAction
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

    public function __invoke(Image $data)
    {
        $this->validator->validate($data);
        $data->setDeletedAt(new \DateTime('now'));
        $this->entityManager->flush($data);

        return $data;

    }

}