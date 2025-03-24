<?php

namespace App\Entity;

use App\Repository\MailingRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MailingRepository::class)]
class Mailing
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $name = null;

    #[ORM\Column(length: 120)]
    private ?string $email = null;

    #[ORM\Column(nullable: true)]
    private ?bool $asMsg = null;

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

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function isAsMsg(): ?bool
    {
        return $this->asMsg;
    }

    public function setAsMsg(?bool $asMsg): static
    {
        $this->asMsg = $asMsg;

        return $this;
    }
}
