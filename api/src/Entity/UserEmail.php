<?php

namespace App\Entity;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ApiResource(
 *     collectionOperations={
 *     "post"={"path"="/recover-password"},
 *     "get"={}
 * },
 *     itemOperations={}
 * )
 */
class UserEmail
{
    /**
     * @Assert\NotBlank()
     * @Assert\Email( message = "The email '{{ value }}' is not a valid email." )
     */
    public $email;
}
