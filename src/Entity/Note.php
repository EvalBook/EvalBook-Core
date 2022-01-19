<?php

namespace EvalBookCore\Entity;

use EvalBookCore\Repository\NoteRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=NoteRepository::class)
 */
class Note
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
     * @ORM\Column(type="datetime")
     */
    private \DateTimeInterface $date;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private string $comment;

    /**
     * @ORM\ManyToOne(targetEntity=Activity::class, inversedBy="notes")
     * @ORM\JoinColumn(nullable=false)
     */
    private Activity $activity;

    /**
     * @ORM\ManyToOne(targetEntity=Pupil::class, inversedBy="notes")
     * @ORM\JoinColumn(nullable=false)
     */
    private Pupil $pupil;


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
     * @return \DateTimeInterface|null
     */
    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    /**
     * @param \DateTimeInterface $date
     * @return $this
     */
    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;
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
     * @return Activity|null
     */
    public function getActivity(): ?Activity
    {
        return $this->activity;
    }

    /**
     * @param Activity|null $activity
     * @return $this
     */
    public function setActivity(?Activity $activity): self
    {
        $this->activity = $activity;
        return $this;
    }

    /**
     * @return Pupil|null
     */
    public function getPupil(): ?Pupil
    {
        return $this->pupil;
    }

    /**
     * @param Pupil|null $pupil
     * @return $this
     */
    public function setPupil(?Pupil $pupil): self
    {
        $this->pupil = $pupil;
        return $this;
    }
}
