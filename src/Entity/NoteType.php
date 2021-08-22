<?php

namespace App\Entity;

use App\Repository\NoteTypeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=NoteTypeRepository::class)
 */
class NoteType
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
     * @ORM\Column(type="integer")
     */
    private int $coefficient;

    /**
     * @ORM\OneToMany(targetEntity=NoteTypeValue::class, mappedBy="note_type", orphanRemoval=true)
     */
    private ArrayCollection $noteTypeValues;


    public function __construct()
    {
        $this->noteTypeValues = new ArrayCollection();
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
     * @return int|null
     */
    public function getCoefficient(): ?int
    {
        return $this->coefficient;
    }

    /**
     * @param int $coefficient
     * @return $this
     */
    public function setCoefficient(int $coefficient): self
    {
        $this->coefficient = $coefficient;
        return $this;
    }

    /**
     * @return Collection|NoteTypeValue[]
     */
    public function getNoteTypeValues(): Collection
    {
        return $this->noteTypeValues;
    }

    /**
     * @param NoteTypeValue $noteTypeValue
     * @return $this
     */
    public function addNoteTypeValue(NoteTypeValue $noteTypeValue): self
    {
        if (!$this->noteTypeValues->contains($noteTypeValue)) {
            $this->noteTypeValues[] = $noteTypeValue;
            $noteTypeValue->setNoteType($this);
        }

        return $this;
    }

    /**
     * @param NoteTypeValue $noteTypeValue
     * @return $this
     */
    public function removeNoteTypeValue(NoteTypeValue $noteTypeValue): self
    {
        if ($this->noteTypeValues->removeElement($noteTypeValue)) {
            // set the owning side to null (unless already changed)
            if ($noteTypeValue->getNoteType() === $this) {
                $noteTypeValue->setNoteType(null);
            }
        }

        return $this;
    }
}
