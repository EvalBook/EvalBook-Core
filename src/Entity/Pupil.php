<?php

namespace App\Entity;

use App\Repository\PupilRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use JetBrains\PhpStorm\Pure;

/**
 * @ORM\Entity(repositoryClass=PupilRepository::class)
 */
class Pupil
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
    private string $last_name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $first_name;

    /**
     * @ORM\Column(type="datetime")
     */
    private \DateTimeInterface $birthdate;

    /**
     * @ORM\ManyToMany(targetEntity=Classroom::class, inversedBy="pupils")
     */
    private ArrayCollection $classrooms;

    /**
     * @ORM\OneToMany(targetEntity=PupilContact::class, mappedBy="pupil", orphanRemoval=true)
     */
    private ArrayCollection $pupilContacts;

    /**
     * @ORM\OneToMany(targetEntity=Note::class, mappedBy="pupil", orphanRemoval=true)
     */
    private ArrayCollection $notes;


    #[Pure] public function __construct()
    {
        $this->classrooms = new ArrayCollection();
        $this->pupilContacts = new ArrayCollection();
        $this->notes = new ArrayCollection();
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
     * @return \DateTimeInterface|null
     */
    public function getBirthdate(): ?\DateTimeInterface
    {
        return $this->birthdate;
    }

    /**
     * @param \DateTimeInterface $birthdate
     * @return $this
     */
    public function setBirthdate(\DateTimeInterface $birthdate): self
    {
        $this->birthdate = $birthdate;
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
        }

        return $this;
    }

    /**
     * @param Classroom $classroom
     * @return $this
     */
    public function removeClassroom(Classroom $classroom): self
    {
        $this->classrooms->removeElement($classroom);
        return $this;
    }

    /**
     * @return Collection|PupilContact[]
     */
    public function getPupilContacts(): Collection
    {
        return $this->pupilContacts;
    }

    /**
     * @param PupilContact $pupilContact
     * @return $this
     */
    public function addPupilContact(PupilContact $pupilContact): self
    {
        if (!$this->pupilContacts->contains($pupilContact)) {
            $this->pupilContacts[] = $pupilContact;
            $pupilContact->setPupil($this);
        }

        return $this;
    }

    /**
     * @param PupilContact $pupilContact
     * @return $this
     */
    public function removePupilContact(PupilContact $pupilContact): self
    {
        if ($this->pupilContacts->removeElement($pupilContact)) {
            // set the owning side to null (unless already changed)
            if ($pupilContact->getPupil() === $this) {
                $pupilContact->setPupil(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Note[]
     */
    public function getNotes(): Collection
    {
        return $this->notes;
    }

    /**
     * @param Note $note
     * @return $this
     */
    public function addNote(Note $note): self
    {
        if (!$this->notes->contains($note)) {
            $this->notes[] = $note;
            $note->setPupil($this);
        }

        return $this;
    }

    /**
     * @param Note $note
     * @return $this
     */
    public function removeNote(Note $note): self
    {
        if ($this->notes->removeElement($note)) {
            // set the owning side to null (unless already changed)
            if ($note->getPupil() === $this) {
                $note->setPupil(null);
            }
        }

        return $this;
    }
}
