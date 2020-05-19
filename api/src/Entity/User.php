<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\Validator\Constraints as SecurityAssert;
use App\Controller\ResetPasswordAction;
use App\Controller\SetPictureAction;
use App\Controller\GetImagesAction;
/**
 * @ApiResource(attributes={"validation_groups"={"user:get", "user:post", "user:put"}},
 *     collectionOperations={
 *     "post"={"denormalization_context"={"groups"={"user:post"}}},
 *     "get"={"normalization_context"={"groups"={"user:get"}}}
 *
 * },
 *     itemOperations={
 *     "get"={
 *     "access_control"="is_granted('IS_AUTHENTICATED_FULLY') and object == user  or is_granted('ROLE_ADMIN')",
 *     "normalization_context"={"groups"={"user:get"}}
 * },
 *
 *     "put"={
 *     "access_control"="is_granted('IS_AUTHENTICATED_FULLY') and object == user or is_granted('ROLE_ADMIN')",
 *     "normalization_context"={"groups"={"user:get"}},
 *     "denormalization_context"={"groups"={"user:put"}}
 * },
 *     "delete"={"access_control"="is_granted('IS_AUTHENTICATED_FULLY') and object == user or is_granted('ROLE_ADMIN')"},
 *
 *     "put-password"={
 *          "access_control"="is_granted('IS_AUTHENTICATED_FULLY') and object == user",
 *          "method"="PUT",
 *          "path"="/users/{id}/reset-password",
 *          "controller"= ResetPasswordAction::class,
 *          "denormalization_context"={"groups"={"user:reset:password"}}
 *     },
 *    "set-picture"={
 *          "access_control"="is_granted('IS_AUTHENTICATED_FULLY') and object == user",
 *          "method"="PUT",
 *          "path"="/users/{id}/set-picture",
 *          "controller"= SetPictureAction::class,
 *          "denormalization_context"={"groups"={"user:set:picture"}}
 * },
 *    "get-images-by-user"={
 *    "method"="GET",
 *    "path"="/user/{id}/images",
 *    "controller"= GetImagesAction::class,
 *    "denormalization_context"={"groups"={"user:get"}}
 *     }
 * }
 * )
 * @ORM\Table(name="users")
 * @ORM\HasLifecycleCallbacks
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User implements UserInterface
{

    /**
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function updatedTimestamps(): void
    {
        $this->setUpdatedAt(new \DateTime('now'));
        if ($this->getCreatedAt() === null) {
            $this->setCreatedAt(new \DateTime('now'));
        }
    }

    /**
     * @Groups({"user:get"})
     * @ORM\Id
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Groups({"user:post","user:get"})
     * @Assert\NotBlank()
     * @Assert\Length(min=3, max=180)
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $username;

    /**
     * @Groups({"user:post","user:get","user:put"})
     * @ORM\Column(type="binary_roles", nullable=false)
     */
    private $roles = [];

    /**
     * @Groups({"user:post"})
     * @Assert\NotBlank()
     * @Assert\Regex(
     *     pattern="/(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9]).{7,}/",
     *     message="Password must be seven characters long and contain at least one digit, one upper case letter and one lower case letter"
     * )
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @Groups({"user:get"})
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @Groups({"user:get"})
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updatedAt;

    public function getId()
    {
        return $this->id;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles   = $this->roles;
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }



    /**************************
     * PASSWORD RESET SECTION *
     **************************/


    /**
     * @ORM\Column(name="password_change_date", type="integer", nullable=true)
     */
    private $passwordChangeDate;

    /**
     * @Groups({"user:reset:password"})
     * @SecurityAssert\UserPassword( message = "Wrong value for your current password" )
     */
    private $oldPassword;

    /**
     * @Groups({"user:reset:password"})
     * @Assert\NotBlank(groups={"user:reset:password"})
     * @Assert\Regex(
     *     pattern="/(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9]).{7,}/",
     *     message="Password must be seven characters long and contain at least one digit, one upper case letter and one lower case letter"
     * )
     */
    private $newPassword;

    /**
     * @Groups({"user:reset:password"})
     * @Assert\NotBlank(groups={"user:reset:password"})
     * @Assert\Expression(
     *     "this.getNewPassword() === this.getNewRetypedPassword()",
     *      message="passwords does not match")
     */
    private $newRetypedPassword;


    public function getPasswordChangeDate()
    {
        return $this->passwordChangeDate;
    }

    public function setPasswordChangeDate($passwordChangeDate)
    {
        $this->passwordChangeDate = $passwordChangeDate;

        return $this;
    }

    public function getNewPassword()
    {
        return $this->newPassword;
    }

    public function setNewPassword($newPassword)
    {
        $this->newPassword = $newPassword;

        return $this;
    }

    public function getNewRetypedPassword()
    {
        return $this->newRetypedPassword;
    }

    public function setNewRetypedPassword($newRetypedPassword)
    {
        $this->newRetypedPassword = $newRetypedPassword;

        return $this;
    }

    public function getOldPassword()
    {
        return $this->oldPassword;
    }

    public function setOldPassword($oldPassword)
    {
        $this->oldPassword = $oldPassword;

        return $this;
    }




    /**************************
     * ADD NEW FIELDS TO USER *
     **************************/



    /**
     * @Groups({"user:post","user:get","user:put"})
     * @Assert\NotBlank()
     * @Assert\Length(min=3, max=180)
     * @ORM\Column(type="string", length=255)
     */
    private $fname;

    /**
     * @Groups({"user:post","user:get","user:put"})
     * @Assert\NotBlank()
     * @Assert\Length(min=3, max=180)
     * @ORM\Column(type="string", length=255)
     */
    private $lname;

    /**
     * @Groups({"user:post","user:get","user:put"})
     * @Assert\NotBlank()
     * @Assert\Email( message = "The email '{{ value }}' is not a valid email." )
     * @ORM\Column(type="string", length=255, unique=true)
     */
    private $email;

    /**
     * @Groups({"user:post","user:get","user:put"})
     * @Assert\Regex(
     *     pattern="/^[1-9]\d{7}$/",
     *     message="Mobile number must be 8 digits"
     * )
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $mobile;

    /**
     * @Groups({"user:post","user:get","user:put"})
     * @Assert\Regex(
     *     pattern="/^[1-9]\d{7}$/",
     *     message="Landline number must be 8 digits"
     * )
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $landline;

    /**
     * @Groups({"user:post","user:get","user:put"})
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $address;

    /**
     * @Groups({"user:post","user:get","user:put"})
     * @ORM\Column(type="text", nullable=true)
     */
    private $bio;



    public function getFname(): ?string
    {
        return $this->fname;
    }

    public function setFname(string $fname): self
    {
        $this->fname = $fname;

        return $this;
    }

    public function getLname(): ?string
    {
        return $this->lname;
    }

    public function setLname(string $lname): self
    {
        $this->lname = $lname;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(?string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getBio(): ?string
    {
        return $this->bio;
    }

    public function setBio(?string $bio): self
    {
        $this->bio = $bio;

        return $this;
    }

    public function getMobile(): ?string
    {
        return $this->mobile;
    }

    public function setMobile(?string $mobile): self
    {
        $this->mobile = $mobile;

        return $this;
    }

    public function getLandline(): ?string
    {
        return $this->landline;
    }

    public function setLandline(?string $landline): self
    {
        $this->landline = $landline;

        return $this;
    }




    /***********************************
     * ADD CONFIRMATION FIELDS TO USER *
     ***********************************/





    /**
     * @ORM\Column(type="boolean", options={"default":"0"})
     */
    private $enabled=false;

    /**
     * @ORM\Column(type="string", length=40, nullable=true)
     */
    private $confirmationToken;

    /**
     * @Groups({"user:post","user:get"})
     * @Assert\Type(
     *     type="bool",
     *     message="The value {{ value }} is not a valid {{ type }}."
     * )
     * @ORM\Column(type="boolean")
     */
    private $agreement;
    /**
     * @Groups({"user:post","user:get"})
     * @ORM\OneToMany(targetEntity="App\Entity\Image", mappedBy="owner", orphanRemoval=true)
     */
    private $images;

    /**
     * @Groups({"user:get","user:set:picture"})
     * @ORM\Column(type="string", nullable=true)
     */
    private $picture;
    /**
     * @Groups({"user:set:picture"})
     * @Assert\NotBlank(groups={"user:set:picture"})
     * @Assert\Regex(
     *     pattern="/^[0-9]*$/",
     *     message="Picture Id needs to be an Integer"
     * )
     */
    private $pic;

    public function __construct()
    {
        $this->images = new ArrayCollection();
    }


    public function getEnabled(): ?bool
    {
        return $this->enabled;
    }

    public function setEnabled(bool $enabled): self
    {
        $this->enabled = $enabled;

        return $this;
    }

    public function getConfirmationToken(): ?string
    {
        return $this->confirmationToken;
    }

    public function setConfirmationToken(?string $confirmationToken): self
    {
        $this->confirmationToken = $confirmationToken;

        return $this;
    }

    /**
     * @return Collection|Image[]
     */
    public function getImages(): Collection
    {
        return $this->images;
    }

    public function addImage(Image $image): self
    {
        if (!$this->images->contains($image)) {
            $this->images[] = $image;
            $image->setOwner($this);
        }

        return $this;
    }

    public function removeImage(Image $image): self
    {
        if ($this->images->contains($image)) {
            $this->images->removeElement($image);
            // set the owning side to null (unless already changed)
            if ($image->getOwner() === $this) {
                $image->setOwner(null);
            }
        }

        return $this;
    }


    public function getAgreement(): ?bool
    {
        return $this->agreement;
    }

    public function setAgreement(bool $agreement): self
    {
        $this->agreement = $agreement;

        return $this;
    }

    public function getPicture(): ?int
    {
        return $this->picture;
    }

    public function setPicture(?string $picture): self
    {
        $this->picture = $picture;

        return $this;
    }


    /**
     * Get the value of pic
     */
    public function getPic()
    {
        return $this->pic;
    }

    /**
     * Set the value of pic
     *
     * @return  self
     */
    public function setPic($pic)
    {
        $this->pic = $pic;

        return $this;
    }
}
