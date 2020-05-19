<?php


namespace App\Controller;

use App\Entity\Image;
use Doctrine\ORM\EntityManagerInterface;

class PrivacyImageAction
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;


    public function __construct( EntityManagerInterface $entityManager )
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param Image $data
     * @return Image
     */
    public function __invoke(Image $data)
    {
        $data->setPrivate($data->getIsPrivate());
        //$this->entityManager->flush($data);

        return $data;

    }

}
