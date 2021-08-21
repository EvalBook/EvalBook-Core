<?php

namespace App\Entity;

use App\Repository\ClassroomRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ClassroomRepository::class)
 */
class Classroom
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $name;

    /**
     * @ORM\ManyToOne(targetEntity=Implantation::class, inversedBy="classrooms")
     * @ORM\JoinColumn(nullable=false)
     */
    private Implantation $implantation;

    /**
     * @ORM\OneToOne(targetEntity=User::class, inversedBy="ownedClassroom", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private User $owner;

    /**
     * @ORM\ManyToMany(targetEntity=User::class, inversedBy="classrooms")
     */
    private $users;

    public function __construct()
    {
        $this->users = new ArrayCollection();
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
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return $this
     */
    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return Implantation|null
     */
    public function getImplantation(): ?Implantation
    {
        return $this->implantation;
    }

    /**
     * @param Implantation|null $implantation
     * @return $this
     */
    public function setImplantation(?Implantation $implantation): self
    {
        $this->implantation = $implantation;
        return $this;
    }

    /**
     * @return User|null
     */
    public function getOwner(): ?User
    {
        return $this->owner;
    }

    /**
     * @param User $owner
     * @return $this
     */
    public function setOwner(User $owner): self
    {
        $this->owner = $owner;
        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        $this->users->removeElement($user);

        return $this;
    }

}
