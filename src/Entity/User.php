<?php

namespace App\Entity;


use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;


#[UniqueEntity('email')]
#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\EntityListeners(['App\EntityListener\UserListener'])]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    
    #[ORM\Column(type : 'string', length: 255)]
    #[Assert\NoBlank()]
    #[Assert\Lenght(min: 2, max: 50)]
    private ?string $fullname = null;

    #[ORM\Column(type : 'string', length: 50, nullable: true)]
    #[Assert\Lenght(min: 2, max: 50)]
    private ?string $pseudo = null;


    #[ORM\Column(type : 'string', length: 180, unique: true)]
    #[Assert\Email()]
    #[Assert\Lenght(min: 2, max: 50)]
    private ?string $email = null;

    #[ORM\Column(type: 'json')]
    #[Assert\NoNull()]
    private array $roles = [];


    #[ORM\Column(type : 'string')]
    #[Assert\NotBlank()]
    private ?string $password = null;


    private  ?string $plainPassword = null;

    private  ?string $newPassword = null;

    #[ORM\Column(type: 'datetime_immutable')]
    #[Assert\NoNull()]
    private ?\DateTimeImmutable $createAt = null;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Ingredients::class, orphanRemoval: true)]
    private Collection $listIngredient;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Recettes::class, orphanRemoval: true)]
    private Collection $ListRecette;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Recettes::class)]
    private Collection $ListeRcette;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Mark::class)]
    private Collection $marks;


    public function __construct()
    {
        $this->createAt = new \DateTimeImmutable();
        $this->listIngredient = new ArrayCollection();
        $this->ListRecette = new ArrayCollection();
        $this->ListeRcette = new ArrayCollection();
        $this->marks = new ArrayCollection();
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
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }


    public function getPlainPassword(): ?string
    {
        return $this->plainPassword;
    }

    public function setPlainPassword(string $plainPassword): static
    {
        $this->plainPassword = $plainPassword;

        return $this;
    }

    public function getNewPassword(): ?string
    {
        return $this->newPassword;
    }

    public function setNewPassword(string $newPassword): static
    {
        $this->newPassword = $newPassword;

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

    public function getFullname(): ?string
    {
        return $this->fullname;
    }

    public function setFullname(string $fullname): static
    {
        $this->fullname = $fullname;

        return $this;
    }

    public function getPseudo(): ?string
    {
        return $this->pseudo;
    }

    public function setPseudo(string $pseudo): static
    {
        $this->pseudo = $pseudo;

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

    /**
     * @return Collection<int, Ingredients>
     */
    public function getListIngredient(): Collection
    {
        return $this->listIngredient;
    }

    public function addListIngredient(Ingredients $listIngredient): static
    {
        if (!$this->listIngredient->contains($listIngredient)) {
            $this->listIngredient->add($listIngredient);
            $listIngredient->setUser($this);
        }

        return $this;
    }

    public function removeListIngredient(Ingredients $listIngredient): static
    {
        if ($this->listIngredient->removeElement($listIngredient)) {
            // set the owning side to null (unless already changed)
            if ($listIngredient->getUser() === $this) {
                $listIngredient->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Recettes>
     */
    public function getListeRcette(): Collection
    {
        return $this->ListeRcette;
    }

    public function addListeRcette(Recettes $listeRcette): static
    {
        if (!$this->ListeRcette->contains($listeRcette)) {
            $this->ListeRcette->add($listeRcette);
            $listeRcette->setUser($this);
        }

        return $this;
    }

    public function removeListeRcette(Recettes $listeRcette): static
    {
        if ($this->ListeRcette->removeElement($listeRcette)) {
            // set the owning side to null (unless already changed)
            if ($listeRcette->getUser() === $this) {
                $listeRcette->setUser(null);
            }
        }

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
            $mark->setUser($this);
        }

        return $this;
    }

    public function removeMark(Mark $mark): static
    {
        if ($this->marks->removeElement($mark)) {
            // set the owning side to null (unless already changed)
            if ($mark->getUser() === $this) {
                $mark->setUser(null);
            }
        }

        return $this;
    }

 
}