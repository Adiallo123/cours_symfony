<?php

namespace App\Entity;

use App\Repository\MarkRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;


#[ORM\Entity(repositoryClass: MarkRepository::class)]
#[UniqueEntity(
    fields:['user', 'recette'],
    errorPath:'user',
    message: 'Cet utilisateur à déja commenté cette recette'
)]
class Mark
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(type: 'integer')]
    #[Assert\PositiveOrZero()]
    #[Assert\LessThan(6)]
    private ?int $mark = null;

    #[ORM\ManyToOne(targetEntity:User::class, inversedBy: 'marks')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\ManyToOne(targetEntity:Recettes::class, inversedBy: 'marks')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Recettes $recette = null;

    #[ORM\Column(type: 'datetime_immutable')]
    private ?\DateTimeImmutable $createdAt = null;

    public function __Construct()
    {
        $this->createdAt = new \DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMark(): ?int
    {
        return $this->mark;
    }

    public function setMark(int $mark): static
    {
        $this->mark = $mark;

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

    public function getRecette(): ?Recettes
    {
        return $this->recette;
    }

    public function setRecette(?Recettes $recette): static
    {
        $this->recette = $recette;

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
}
