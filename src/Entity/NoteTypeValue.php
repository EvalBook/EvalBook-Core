<?php

namespace EvalBookCore\Entity;

use EvalBookCore\Repository\NoteTypeValueRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=NoteTypeValueRepository::class)
 */
class NoteTypeValue
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
    private string $value;

    /**
     * @ORM\ManyToOne(targetEntity=NoteType::class, inversedBy="noteTypeValues")
     * @ORM\JoinColumn(nullable=false)
     */
    private NoteType $note_type;


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
    public function getValue(): ?string
    {
        return $this->value;
    }

    /**
     * @param string $value
     * @return $this
     */
    public function setValue(string $value): self
    {
        $this->value = $value;
        return $this;
    }

    /**
     * @return NoteType|null
     */
    public function getNoteType(): ?NoteType
    {
        return $this->note_type;
    }

    /**
     * @param NoteType|null $note_type
     * @return $this
     */
    public function setNoteType(?NoteType $note_type): self
    {
        $this->note_type = $note_type;
        return $this;
    }
}
