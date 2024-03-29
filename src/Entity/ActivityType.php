<?php

namespace EvalBookCore\Entity;

use EvalBookCore\Repository\ActivityTypeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use JetBrains\PhpStorm\Pure;

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
     * @ORM\OneToMany(targetEntity=Activity::class, mappedBy="activity_type", orphanRemoval=true)
     */
    private ArrayCollection $activities;


    #[Pure] public function __construct()
    {
        $this->activities = new ArrayCollection();
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

    /**
     * @return Collection|Activity[]
     */
    public function getActivities(): Collection
    {
        return $this->activities;
    }

    /**
     * @param Activity $activity
     * @return $this
     */
    public function addActivity(Activity $activity): self
    {
        if (!$this->activities->contains($activity)) {
            $this->activities[] = $activity;
            $activity->setActivityType($this);
        }

        return $this;
    }

    /**
     * @param Activity $activity
     * @return $this
     */
    public function removeActivity(Activity $activity): self
    {
        if ($this->activities->removeElement($activity)) {
            // set the owning side to null (unless already changed)
            if ($activity->getActivityType() === $this) {
                $activity->setActivityType(null);
            }
        }

        return $this;
    }
}
