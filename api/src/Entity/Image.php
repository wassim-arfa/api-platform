<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use App\Controller\UploadImageAction;
use App\Controller\DeleteImageAction;

/**
 * @ORM\Entity()
 * @Vich\Uploadable()
 * @ApiResource(
 *     attributes={
 *         "order"={"id": "ASC"},
 *         "formats"={"json", "jsonld", "form"={"multipart/form-data"}}
 *     },
 *     collectionOperations={
 *         "get"={"normalization_context"={"groups"={"image:get"}},
 *                "access_control"="is_granted('IS_AUTHENTICATED_FULLY')"},
 *         "post"={
 *             "method"="POST",
 *             "path"="/images",
 *             "controller"=UploadImageAction::class,
 *             "defaults"={"_api_receive"=false},
 *             "access_control"="is_granted('IS_AUTHENTICATED_FULLY')",
 *         }
 *     },
 *     itemOperations={
 *           "get"={
 *           "path"="/image/{id}",
 *           "access_control"="is_granted('IS_AUTHENTICATED_FULLY')",
 *           "normalization_context"={"groups"={"image:get"}}
 * },
 *           "safe-delete"={
 *             "method"="PUT",
 *             "path"="/delete-image/{id}",
 *             "controller"=DeleteImageAction::class,
 *             "access_control"="is_granted('IS_AUTHENTICATED_FULLY')",
 *         }
 *     }
 * )
 */
class Image
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"image:get"})
     */
    private $id;

    /**
     * @Vich\UploadableField(mapping="images", fileNameProperty="url")
     * @Assert\NotNull(groups={"post"})
     */
    private $file;

    /**
     * @Groups({"image:get"})
     * @ORM\Column(nullable=true)
     */
    private $url;

    /**
     * @Groups({"image:get"})
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="images")
     * @ORM\JoinColumn(nullable=false)
     */
    private $owner;

    /**
     * @Groups({"image:get"})
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $deletedAt;

    public function getId()
    {
        return $this->id;
    }

    public function getFile()
    {
        return $this->file;
    }

    public function setFile($file): void
    {
        $this->file = $file;
    }

    public function getUrl()
    {
        return '/images/' . $this->url;
    }

    public function setUrl($url): void
    {
        $this->url = $url;
    }

    public function __toString()
    {
        return $this->id . ':' . $this->url;
    }

    public function getOwner(): ?User
    {
        return $this->owner;
    }

    public function setOwner(?User $owner): self
    {
        $this->owner = $owner;

        return $this;
    }

    public function getDeletedAt(): ?\DateTimeInterface
    {
        return $this->deletedAt;
    }

    public function setDeletedAt(?\DateTimeInterface $deletedAt): self
    {
        $this->deletedAt = $deletedAt;

        return $this;
    }
}
