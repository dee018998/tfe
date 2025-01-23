<?php

namespace App\Entity;

use App\Repository\CommentRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: CommentRepository::class)]
class Comment
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;
    #[Assert\Length(
        max: 300,
        maxMessage : "La présentation ne peut contenir plus de  {{ limit }} caractères",
    )]
    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $content = null;
   /* #[Assert\DateTime]*/
    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[Assert\NotBlank]
    #[Assert\Type(
        type: 'integer',
        message: "Le prix {{ value }} ne peut pas être un {{ type }}.",
    )]
    #[Assert\Positive]
    #[Assert\LessThan(
    value: 6,
    message: 'Vous devez donner une note au dessous de cinq'
)]
    #[Assert\GreaterThan(
        value: 0,
        message: 'Vous devez donner une note au dessus de zéro'
    )]
    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $rating = null;

    #[ORM\ManyToOne(inversedBy: 'comments')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Course $course = null;

    #[ORM\ManyToOne(inversedBy: 'comments')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\Column]
    private ?bool $isPublished = null;

    #[ORM\Column]
    private ?bool $isModarated = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(?string $content): static
    {
        $this->content = $content;

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

    public function getRating(): ?int
    {
        return $this->rating;
    }

    public function setRating(int $rating): static
    {
        $this->rating = $rating;

        return $this;
    }

    public function getCourse(): ?Course
    {
        return $this->course;
    }

    public function setCourse(?Course $course): static
    {
        $this->course = $course;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    public function isPublished(): ?bool
    {
        return $this->isPublished;
    }

    public function setPublished(bool $isPublished): static
    {
        $this->isPublished = $isPublished;

        return $this;
    }

    public function isModarated(): ?bool
    {
        return $this->isModarated;
    }

    public function setModarated(bool $isModarated): static
    {
        $this->isModarated = $isModarated;

        return $this;
    }


}
