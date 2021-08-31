<?php

namespace App\Entity;

use App\Repository\PeriodRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use JetBrains\PhpStorm\Pure;

/**
 * @ORM\Entity(repositoryClass=PeriodRepository::class)
 */
class Period
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\Column(type="string", length=45)
     */
    private string $name;

    /**
     * @ORM\Column(type="datetime")
     */
    private \DateTimeInterface $date_start;

    /**
     * @ORM\Column(type="datetime")
     */
    private \DateTimeInterface $date_end;

    /**
     * @ORM\Column(type="boolean")
     */
    private bool $is_active;

    /**
     * @ORM\ManyToOne(targetEntity=Implantation::class, inversedBy="periods")
     * @ORM\JoinColumn(nullable=false)
     */
    private Implantation $implantation;

    /**
     * @ORM\OneToMany(targetEntity=Activity::class, mappedBy="period", orphanRemoval=true)
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
     * @return \DateTimeInterface|null
     */
    public function getDateStart(): ?\DateTimeInterface
    {
        return $this->date_start;
    }

    /**
     * @param \DateTimeInterface $date_start
     * @return $this
     */
    public function setDateStart(\DateTimeInterface $date_start): self
    {
        $this->date_start = $date_start;
        return $this;
    }

    /**
     * @return \DateTimeInterface|null
     */
    public function getDateEnd(): ?\DateTimeInterface
    {
        return $this->date_end;
    }

    /**
     * @param \DateTimeInterface $date_end
     * @return $this
     */
    public function setDateEnd(\DateTimeInterface $date_end): self
    {
        $this->date_end = $date_end;
        return $this;
    }

    /**
     * @return bool|null
     */
    public function isActive(): ?bool
    {
        return $this->is_active;
    }

    /**
     * @param bool $active
     * @return $this
     */
    public function setActive(bool $active): self
    {
        $this->is_active = $active;
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
            $activity->setPeriod($this);
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
            if ($activity->getPeriod() === $this) {
                $activity->setPeriod(null);
            }
        }

        return $this;
    }
}
