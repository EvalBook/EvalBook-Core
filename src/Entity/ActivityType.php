<?php

namespace App\Entity;

use App\Repository\ActivityTypeRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ActivityTypeRepository::class)
 */
class ActivityType
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
     * @ORM\Column(type="boolean")
     */
    private bool $is_active_in_school_report;

    /**
     * @ORM\ManyToOne(targetEntity=NoteType::class)
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
     * @return bool|null
     */
    public function getIsActiveInSchoolReport(): ?bool
    {
        return $this->is_active_in_school_report;
    }

    /**
     * @param bool $is_active_in_school_report
     * @return $this
     */
    public function setIsActiveInSchoolReport(bool $is_active_in_school_report): self
    {
        $this->is_active_in_school_report = $is_active_in_school_report;
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
