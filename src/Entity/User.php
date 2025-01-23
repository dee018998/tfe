<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints\PasswordStrength;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;

#[Vich\Uploadable]
#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_EMAIL', fields: ['email'])]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;
    #[Assert\Email(
        message: "l'email {{ value }} n'est pas une email valide.",
    )]
    #[ORM\Column(length: 180)]
    private ?string $email = null;

    /**
     * @var list<string> The user roles
     */
    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */

    /*#[Assert\NotBlank]*/
    #[Assert\PasswordStrength([
        'message' => "Utiliser un mot de passe plus sur"
    ])]
    #[ORM\Column]
    private ?string $password = null;
    #[Assert\NotBlank]
    #[Assert\Length(
        min: 3,
        max: 120,
        minMessage : "Votre prénom doit contenir au moins {{ limit }} caractères",

        maxMessage : "Votre prénom ne peut contenir plus de  {{ limit }} caractères",
    )]
    #[Assert\Regex(
        pattern: '/^[a-zA-Z-]+$/',
        message: 'Votre nom contient des caractères non autorisés',
    )]
    #[ORM\Column(length: 120)]
    private ?string $firstName = null;

    #[Assert\NotBlank]
    #[Assert\Length(
        min: 3,
        max: 120,
        minMessage : "Votre nom doit contenir au moins {{ limit }} caractères",

        maxMessage : "Votre nom ne peut contenir plus de  {{ limit }} caractères",
    )]
    #[Assert\Regex(
        pattern: '/^[a-z]+$/i',
        message: 'Votre nom contient des caractères non autorisés',
    )]
    #[ORM\Column(length: 120)]
    private ?string $lastName = null;
    #[ORM\Column(length: 255,nullable: true)]
    private ?string $image = null;
    #[Vich\UploadableField(mapping: 'users', fileNameProperty: 'image')]
    private ?File $imageFile = null;





    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updatedAt;

    #[ORM\Column]
    private ?bool $isDisabled = null;
    /**
     * @var Collection<int, Comment>
     */
    #[ORM\OneToMany(targetEntity: Comment::class, mappedBy: 'user',cascade: ['remove'])]
    private Collection $comments;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $lastLogAt = null;

    /**
     * @var Collection<int, Course>
     */
    #[ORM\ManyToMany(targetEntity: Course::class, inversedBy: 'users')]
    private Collection $course;

    public function __construct()
    {
        $this->comments = new ArrayCollection();
        $this->course = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     * @return list<string>
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        //$roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    /**
     * @param list<string> $roles
     */
    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): static
    {
        $this->firstName = $firstName;

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

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeImmutable $updatedAt): static
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function isDisabled(): ?bool
    {
        return $this->isDisabled;
    }

    public function setDisabled(bool $isDisabled): static
    {
        $this->isDisabled = $isDisabled;

        return $this;
    }

    /**
     * @return Collection<int, Comment>
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comment $comment): static
    {
        if (!$this->comments->contains($comment)) {
            $this->comments->add($comment);
            $comment->setUser($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): static
    {
        if ($this->comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getUser() === $this) {
                $comment->setUser(null);
            }
        }

        return $this;
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


    public function setImageFile(?File $imageFile = null): void
    {
        $this->imageFile = $imageFile;

        if (null !== $imageFile) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTimeImmutable();
        }
    }

    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }



    public function __serialize(): array
    {
        return [
            $this->id,
            $this->email,
            $this->password


        ];
    }

    public function __unserialize(array $data): void
    {
        [
            $this->id,
            $this->email,
            $this->password
        ]=$data;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): static
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getLastLogAt(): ?\DateTimeImmutable
    {
        return $this->lastLogAt;
    }

    public function setLastLogAt(?\DateTimeImmutable $lastLogAt): static
    {
        $this->lastLogAt = $lastLogAt;

        return $this;
    }

    /**
     * @return Collection<int, Course>
     */
    public function getCourse(): Collection
    {
        return $this->course;
    }

    public function addCourse(Course $course): static
    {
        if (!$this->course->contains($course)) {
            $this->course->add($course);
        }

        return $this;
    }

    public function removeCourse(Course $course): static
    {
        $this->course->removeElement($course);

        return $this;
    }
}
