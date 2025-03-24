<?php

namespace App\Entity;

use App\Repository\ActuRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ActuRepository::class)]
#[Vich\Uploadable]
#[UniqueEntity(
    fields: 'name',
    message: 'Ce titre existe déja'
)]
class Actu
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Assert\NotBlank(
        message : 'Le titre ne peut être vide'
    )]
    #[Assert\Length(
        min: 5,
        max: 200,
        minMessage : "Le titre doit contenir au moins {{ limit }} caractères",

        maxMessage : "Le titre ne peut contenir plus de  {{ limit }} caractères",
    )]
    #[ORM\Column(length: 255)]
    private ?string $name = null;
/*    #[Assert\DateTime]*/
    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;
    #[Assert\NotBlank(
    message : 'Le contenu ne peut être vide'
    )]
    #[Assert\Length(
        min: 10,
        max: 10000,
        minMessage : "Le contenu de l'article doit contenir au moins {{ limit }} caractères",

        maxMessage : "Le contenu de l'article ne peut contenir plus de  {{ limit }} caractères",
    )]
    #[ORM\Column(type: Types::TEXT)]
    private ?string $content = null;

    #[ORM\Column(length: 255)]
    private ?string $slug = null;



    #[Vich\UploadableField(mapping: 'actus', fileNameProperty: 'image')]
    private ?File $imageFile = null;
  /*  #[Assert\DateTime]*/
    #[ORM\Column(length: 255)]
    private ?string $image = null;
    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\Column]
    private ?bool $isPublished = null;

    #[ORM\ManyToOne(inversedBy: 'actus')]
    private ?Family $family = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $publishedAt = null;

    #[ORM\Column(length: 80, nullable: true)]
    private ?string $link = null;

    #[ORM\Column(nullable: true)]
    private ?bool $isVideo = null;
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): static
    {
        $this->content = $content;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): static
    {
        $this->slug = $slug;

        return $this;
    }
    public function setImageFile(?File $imageFile = null): void
    {
        $this->imageFile = $imageFile;
        if (null !== $imageFile) {
            $this->updatedAt = new \DateTimeImmutable();
        }
    }
    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeImmutable $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }
    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): static
    {
        $this->image = $image;

        return $this;
    }

    public function setPublished(bool $isPublished): static
    {

        $this->isPublished = $isPublished;

        return $this;
    }

    public function isPublished()
    {
        return $this->isPublished;
    }

    public function getFamily(): ?Family
    {
        return $this->family;
    }

    public function setFamily(?Family $family): static
    {
        $this->family = $family;

        return $this;
    }

    public function getPublishedAt(): ?\DateTimeImmutable
    {
        return $this->publishedAt;
    }

    public function setPublishedAt(?\DateTimeImmutable $publishedAt): static
    {
        $this->publishedAt = $publishedAt;

        return $this;
    }

    public function getLink(): ?string
    {
        return $this->link;
    }

    public function setLink(?string $link): static
    {
        $this->link = $link;

        return $this;
    }

    public function isVideo(): ?bool
    {
        return $this->isVideo;
    }

    public function setIsVideo(?bool $isVideo): static
    {
        $this->isVideo = $isVideo;

        return $this;
    }
}
