<?php

namespace EvalBookCore\Entity;

use EvalBookCore\Repository\PupilContactRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PupilContactRepository::class)
 */
class PupilContact
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\Column(type="boolean")
     */
    private bool $is_report_sent;

    /**
     * @ORM\ManyToOne(targetEntity=ContactRelation::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private ContactRelation $relation;

    /**
     * @ORM\ManyToOne(targetEntity=Contact::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private Contact $contact;

    /**
     * @ORM\ManyToOne(targetEntity=Pupil::class, inversedBy="pupilContacts")
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
     * @return bool|null
     */
    public function getIsReportSent(): ?bool
    {
        return $this->is_report_sent;
    }

    /**
     * @param bool $is_report_sent
     * @return $this
     */
    public function setIsReportSent(bool $is_report_sent): self
    {
        $this->is_report_sent = $is_report_sent;
        return $this;
    }

    /**
     * @return ContactRelation|null
     */
    public function getRelation(): ?ContactRelation
    {
        return $this->relation;
    }

    /**
     * @param ContactRelation|null $relation
     * @return $this
     */
    public function setRelation(?ContactRelation $relation): self
    {
        $this->relation = $relation;
        return $this;
    }

    /**
     * @return Contact|null
     */
    public function getContact(): ?Contact
    {
        return $this->contact;
    }

    /**
     * @param Contact|null $contact
     * @return $this
     */
    public function setContact(?Contact $contact): self
    {
        $this->contact = $contact;
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
