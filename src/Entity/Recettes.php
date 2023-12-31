<?php

namespace App\Entity;

use App\Repository\RecettesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\HttpFoundation\File\File;





#[ORM\Entity(repositoryClass: RecettesRepository::class)]
#[ORM\HasLifecycleCallbacks]

#[Vich\Uploadable]

#[UniqueEntity('name')]
class Recettes
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 50)]
    #[Assert\NotBlank]
    #[Assert\Length(min: 2, max: 50)]
    private ?string $name = null;

    #[ORM\Column(type: 'integer', nullable: true)]
    #[Assert\Positive()]
    #[Assert\LessThan(1441)]
    private ?int $time = null;

    #[ORM\Column(type: 'integer', nullable: true)]
    #[Assert\Positive()]
    #[Assert\LessThan(50)]
    private ?int $nbPeople = null;

    #[ORM\Column(type: 'integer', nullable: true)]
    #[Assert\Positive()]
    #[Assert\LessThan(6)]
    private ?int $difficulty = null;

    #[ORM\Column(type: 'text', length: 255)]
    #[Assert\NotBlank]
    private ?string $description = null;

    #[ORM\Column(type: 'float')]
    #[Assert\Positive()]
    #[Assert\LessThan(1001)]
    private ?float $price = null;

    #[ORM\Column(type: 'boolean')]
    #[Assert\NotNull()]
    private ?bool $isFavorite = null;

    #[ORM\Column(type: 'datetime_immutable')]
    #[Assert\NotNull()]
    private ?\DateTimeImmutable $createAt = null;

    #[ORM\Column(type: 'datetime_immutable')]
    #[Assert\NotNull()]
    private ?\DateTimeImmutable $updateAt = null;

    #[ORM\ManyToMany(targetEntity: ingredients::class)]
    private Collection $ListeIngredients;


    #[Vich\UploadableField(mapping: 'recette_image', fileNameProperty: 'imageName')]
    private ?File $imageFile = null;

    #[ORM\Column(type: 'string', nullable: true)]
    private ?string $imageName = null;


    #[ORM\ManyToOne(inversedBy: 'ListeRcette')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;


    #[ORM\Column(type: 'boolean')]
    private ?bool $isPublic = false;




    private ?float $average = null;

    #[ORM\OneToMany(mappedBy: 'recette', targetEntity: Mark::class)]
    private Collection $marks;

   

    public function __construct()
    {
        $this->ListeIngredients = new ArrayCollection();
        $this->createAt =  new \DateTimeImmutable();
        $this->updateAt = new \DateTimeImmutable();
        $this->marks = new ArrayCollection();
    }

    #[ORM\PrePersist]
    public function setUpdateAtValue()
    {
        $this->updateAt = new \DateTimeImmutable();
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

    public function getTime(): ?int
    {
        return $this->time;
    }

    public function setTime(?int $time): static
    {
        $this->time = $time;

        return $this;
    }

    public function getNbPeople(): ?int
    {
        return $this->nbPeople;
    }

    public function setNbPeople(?int $nbPeople): static
    {
        $this->nbPeople = $nbPeople;

        return $this;
    }

    public function getDifficulty(): ?int
    {
        return $this->difficulty;
    }

    public function setDifficulty(?int $difficulty): static
    {
        $this->difficulty = $difficulty;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

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

    public function isIsFavorite(): ?bool
    {
        return $this->isFavorite;
    }

    public function setIsFavorite(bool $isFavorite): static
    {
        $this->isFavorite = $isFavorite;

        return $this;
    }

    public function getCreateAt(): ?\DateTimeImmutable
    {
        return $this->createAt;
    }

    public function setCreateAt(\DateTimeImmutable $createAt): static
    {
        $this->createAt = $createAt;

        return $this;
    }

    public function getUpdateAt(): ?\DateTimeImmutable
    {
        return $this->updateAt;
    }

    public function setUpdateAt(\DateTimeImmutable $updateAt): static
    {
        $this->updateAt = $updateAt;

        return $this;
    }

    /**
     * @return Collection<int, ingredients>
     */
    public function getListeIngredients(): Collection
    {
        return $this->ListeIngredients;
    }

    public function addListeIngredient(ingredients $listeIngredient): static
    {
        if (!$this->ListeIngredients->contains($listeIngredient)) {
            $this->ListeIngredients->add($listeIngredient);
        }

        return $this;
    }

    public function removeListeIngredient(ingredients $listeIngredient): static
    {
        $this->ListeIngredients->removeElement($listeIngredient);

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

    public function isIsPublic(): ?bool
    {
        return $this->isPublic;
    }

    public function setIsPublic(bool $isPublic): static
    {
        $this->isPublic = $isPublic;

        return $this;
    }

    /**
     * @return Collection<int, Mark>
     */
    public function getMarks(): Collection
    {
        return $this->marks;
    }

    public function addMark(Mark $mark): static
    {
        if (!$this->marks->contains($mark)) {
            $this->marks->add($mark);
            $mark->setRecette($this);
        }

        return $this;
    }

    public function removeMark(Mark $mark): static
    {
        if ($this->marks->removeElement($mark)) {
            // set the owning side to null (unless already changed)
            if ($mark->getRecette() === $this) {
                $mark->setRecette(null);
            }
        }

        return $this;
    }

    public function getAverage():float
    {
        $mark = $this->marks;

        if($mark->toArray()  === []){
            $this->average = $mark;
            return $this->average;
        }

        $total = 0;

        foreach ($mark as $marks) {
            $total += $marks->getMark();
        }
        $this->average = $total / count($mark);
        return $this->average;
    }

   
}