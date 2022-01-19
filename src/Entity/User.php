<?php

namespace EvalBookCore\Entity;

use EvalBookCore\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use JetBrains\PhpStorm\Pure;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 */
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     */
    private string $email;


     //@ORM\Column(type="json")
    //private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string", length=255)
     */
    private string $password;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $last_name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $first_name;

    /**
     * @ORM\OneToOne(targetEntity=Classroom::class, mappedBy="owner", cascade={"persist", "remove"})
     */
    private Classroom $ownedClassroom;

    /**
     * @ORM\ManyToMany(targetEntity=Classroom::class, mappedBy="users")
     */
    private ArrayCollection $classrooms;

    /**
     * @ORM\ManyToOne(targetEntity=Role::class, inversedBy="users")
     * @ORM\JoinColumn(nullable=false)
     */
    private Role $role;


    #[Pure]
    public function __construct()
    {
        $this->classrooms = new ArrayCollection();
    }


    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @param string $email
     * @return $this
     */
    public function setEmail(string $email): self
    {
        $this->email = $email;
        return $this;
    }

    /**
     * A visual identifier that represents this user.
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return $this->email;
    }

    /**
     * @deprecated since Symfony 5.3, use getUserIdentifier instead
     */
    public function getUsername(): string
    {
        return $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        return [
            'ROLE_USER',
            (string)$this->getRole(),
        ];
    }

    /**
     * Return attribued role except the user very basic role that is only needed to get user connected or simple other things.
     * @return Role|null
     */
    public function getRole(): ?Role
    {
        return $this->role;
    }

    /**
     * @param Role|null $role
     * @return $this
     */
    public function setRole(?Role $role): self
    {
        $this->role = $role;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param string $password
     * @return $this
     */
    public function setPassword(string $password): self
    {
        $this->password = $password;
        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): self
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getLastName(): ?string
    {
        return $this->last_name;
    }

    /**
     * @param string $last_name
     * @return $this
     */
    public function setLastName(string $last_name): self
    {
        $this->last_name = $last_name;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getFirstName(): ?string
    {
        return $this->first_name;
    }

    /**
     * @param string $first_name
     * @return $this
     */
    public function setFirstName(string $first_name): self
    {
        $this->first_name = $first_name;
        return $this;
    }

    /**
     * @return Classroom|null
     */
    public function getOwnedClassroom(): ?Classroom
    {
        return $this->ownedClassroom;
    }

    /**
     * @param Classroom $ownedClassroom
     * @return $this
     */
    public function setOwnedClassroom(Classroom $ownedClassroom): self
    {
        // set the owning side of the relation if necessary
        if ($ownedClassroom->getOwner() !== $this) {
            $ownedClassroom->setOwner($this);
        }

        $this->ownedClassroom = $ownedClassroom;
        return $this;
    }

    /**
     * @return Collection|Classroom[]
     */
    public function getClassrooms(): Collection
    {
        return $this->classrooms;
    }

    /**
     * @param Classroom $classroom
     * @return $this
     */
    public function addClassroom(Classroom $classroom): self
    {
        if (!$this->classrooms->contains($classroom)) {
            $this->classrooms[] = $classroom;
            $classroom->addUser($this);
        }

        return $this;
    }

    /**
     * @param Classroom $classroom
     * @return $this
     */
    public function removeClassroom(Classroom $classroom): self
    {
        if ($this->classrooms->removeElement($classroom)) {
            $classroom->removeUser($this);
        }

        return $this;
    }
}
