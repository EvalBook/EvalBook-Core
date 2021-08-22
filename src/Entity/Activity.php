<?php

namespace App\Entity;

use App\Repository\ActivityRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ActivityRepository::class)
 */
class Activity
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
     * @ORM\Column(type="text", nullable=true)
     */
    private string $comment;

    /**
     * @ORM\ManyToOne(targetEntity=Period::class, inversedBy="activities")
     * @ORM\JoinColumn(nullable=false)
     */
    private Period $period;

    /**
     * @ORM\ManyToOne(targetEntity=ActivityType::class, inversedBy="activities")
     * @ORM\JoinColumn(nullable=false)
     */
    private ActivityType $activity_type;

    /**
     * @ORM\ManyToOne(targetEntity=Classroom::class, inversedBy="activities")
     * @ORM\JoinColumn(nullable=false)
     */
    private Classroom $class;


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
     * @return string|null
     */
    public function getComment(): ?string
    {
        return $this->comment;
    }

    /**
     * @param string|null $comment
     * @return $this
     */
    public function setComment(?string $comment): self
    {
        $this->comment = $comment;
        return $this;
    }

    /**
     * @return Period|null
     */
    public function getPeriod(): ?Period
    {
        return $this->period;
    }

    /**
     * @param Period|null $period
     * @return $this
     */
    public function setPeriod(?Period $period): self
    {
        $this->period = $period;
        return $this;
    }

    /**
     * @return ActivityType|null
     */
    public function getActivityType(): ?ActivityType
    {
        return $this->activity_type;
    }

    /**
     * @param ActivityType|null $activity_type
     * @return $this
     */
    public function setActivityType(?ActivityType $activity_type): self
    {
        $this->activity_type = $activity_type;
        return $this;
    }

    /**
     * @return Classroom|null
     */
    public function getClass(): ?Classroom
    {
        return $this->class;
    }

    /**
     * @param Classroom|null $class
     * @return $this
     */
    public function setClass(?Classroom $class): self
    {
        $this->class = $class;
        return $this;
    }
}
