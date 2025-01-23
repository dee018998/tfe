<?php

namespace App\Entity;

use App\Repository\CourseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;
#[ORM\Entity(repositoryClass: CourseRepository::class)]
#[Vich\Uploadable]
#[UniqueEntity(
    fields: 'name',
    message: 'Ce nom de formation existe déja'
)]
class Course
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;
    #[Assert\NotBlank(
        message : 'Le nom de la formation ne peut être vide'
    )]
    #[Assert\Length(
        min: 15,
        max: 30,
        minMessage : "Le titre doit contenir au moins {{ limit }} caractères",

        maxMessage : "Le titre ne peut contenir plus de  {{ limit }} caractères",
    )]
    #[ORM\Column(length: 120)]
    private ?string $name = null;
    #[Assert\NotBlank(
        message : 'La présentation ne peut être vide'
    )]
    #[Assert\Length(
        min: 70,
        max: 300,
        minMessage : "La présentation doit contenir au moins {{ limit }} caractères",

        maxMessage : "La présentation ne peut contenir plus de  {{ limit }} caractères",
    )]
    #[ORM\Column(type: Types::TEXT)]
    private ?string $smallDescription = null;
    #[Assert\NotBlank(
        message : 'La description ne peut être vide'
    )]
    #[Assert\Length(
        min: 100,
        max: 3000,
        minMessage : "La description doit contenir au moins {{ limit }} caractères",

        maxMessage : "La description µne peut contenir plus de  {{ limit }} caractères",
    )]
    #[ORM\Column(type: Types::TEXT)]
    private ?string $fullDescription = null;
    #[Assert\NotBlank(
        message : 'La durée ne peut être vide'
    )]
    #[ORM\Column(scale: 2)]
    private ?float $duration = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;


/*    #[Assert\DateTime]*/
    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\Column]
    private ?bool $isPublished = null;

    #[ORM\Column(length: 255)]
    private ?string $slug = null;

/*    #[Assert\NotBlank(
        message : "Il faut télécharger une image",
    )]*/
    #[ORM\Column(length: 255)]
    private ?string $image = null;
    #[Vich\UploadableField(mapping: 'courses', fileNameProperty: 'image')]
    private ?File $imageFile = null;



    #[Vich\UploadableField(mapping: 'pdf', fileNameProperty: 'program')]
    private ?File $pdfFile = null;
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $program = null ;



    #[ORM\ManyToOne(inversedBy: 'course')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Category $category = null;

    #[ORM\ManyToOne(inversedBy: 'course')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Level $level = null;
    #[Assert\NotBlank(
        message : 'Le prix ne peut être vide'
    )]
    #[Assert\Type(
        type: 'float',
        message: "Le prix {{ value }} ne peut pas être un {{ type }}.",
    )]
    #[Assert\Positive]
    #[ORM\Column]
    private ?float $price = null;

    /**
     * @var Collection<int, Comment>
     */
    #[ORM\OneToMany(targetEntity: Comment::class, mappedBy: 'course', cascade: ['remove'])]
    private Collection $comments;

    /**
     * @var Collection<int, User>
     */
    #[ORM\ManyToMany(targetEntity: User::class, mappedBy: 'course')]
    private Collection $users;

    #[ORM\Column(length: 255)]
    private ?string $alt = null;

    #[ORM\ManyToOne(inversedBy: 'courses')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Color $color = null;


    public function __construct()
    {
        $this->comments = new ArrayCollection();
        $this->users = new ArrayCollection();
    }



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

    public function getSmallDescription(): ?string
    {
        return $this->smallDescription;
    }

    public function setSmallDescription(string $smallDescription): static
    {
        $this->smallDescription = $smallDescription;

        return $this;
    }

    public function getFullDescription(): ?string
    {
        return $this->fullDescription;
    }

    public function setFullDescription(string $fullDescription): static
    {
        $this->fullDescription = $fullDescription;

        return $this;
    }

    public function getDuration(): ?float
    {
        return $this->duration;
    }

    public function setDuration(float $duration): static
    {
        $this->duration = $duration;

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
    }    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setUpdatedAt(\DateTimeImmutable $updatedAt): static
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }


    public function setImageFile(?File $imageFile = null): void
    {
        $this->imageFile = $imageFile;
        if (null !== $imageFile) {
            $this->updatedAt = new \DateTimeImmutable();
        }
    }
    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }
    public function setPdfFile(?File $pdfFile = null): void
    {
        $this->pdfFile = $pdfFile;
        if (null !== $pdfFile) {
            $this->updatedAt = new \DateTimeImmutable();
        }
    }
    public function getPdfFile(): ?File
    {
        return $this->pdfFile;
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

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): static
    {
        $this->slug = $slug;

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

    public function getProgram(): ?string
    {
        return $this->program;
    }

    public function setProgram(?string $program): static
    {
        $this->program = $program;

        return $this;
    }



    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): static
    {
        $this->category = $category;

        return $this;
    }

    public function getLevel(): ?level
    {
        return $this->level;
    }

    public function setLevel(?level $level): static
    {
        $this->level = $level;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): static
    {
        $this->price = $price;

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
            $comment->setCourse($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): static
    {
        if ($this->comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getCourse() === $this) {
                $comment->setCourse(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): static
    {
        if (!$this->users->contains($user)) {
            $this->users->add($user);
            $user->addCourse($this);
        }

        return $this;
    }

    public function removeUser(User $user): static
    {
        if ($this->users->removeElement($user)) {
            $user->removeCourse($this);
        }

        return $this;
    }

    public function getAlt(): ?string
    {
        return $this->alt;
    }

    public function setAlt(string $alt): static
    {
        $this->alt = $alt;

        return $this;
    }

    public function getColor(): ?color
    {
        return $this->color;
    }

    public function setColor(?color $color): static
    {
        $this->color = $color;

        return $this;
    }




}
