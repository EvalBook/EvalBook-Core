<?php

namespace App\Entity;

use App\Repository\ImplantationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use JetBrains\PhpStorm\Pure;

/**
 * @ORM\Entity(repositoryClass=ImplantationRepository::class)
 */
class Implantation
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
     * @ORM\Column(type="string", length=255)
     */
    private string $street;

    /**
     * @ORM\Column(type="smallint", length=255)
     */
    private int $number;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $city;

    /**
     * @ORM\Column(type="string", length=40)
     */
    private string $zip;

    /**
     * @ORM\ManyToOne(targetEntity=School::class, inversedBy="implantations")
     */
    private School $school;

    /**
     * @ORM\OneToMany(targetEntity=Period::class, mappedBy="implantation", orphanRemoval=true)
     */
    private ArrayCollection $periods;



    #[Pure]
    public function __construct()
    {
        $this->periods = new ArrayCollection();
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
     * @return string|null
     */
    public function getStreet(): ?string
    {
        return $this->street;
    }

    /**
     * @param string $street
     * @return $this
     */
    public function setStreet(string $street): self
    {
        $this->street = $street;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getNumber(): ?string
    {
        return $this->number;
    }

    /**
     * @param string $number
     * @return $this
     */
    public function setNumber(string $number): self
    {
        $this->number = $number;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getCity(): ?string
    {
        return $this->city;
    }

    /**
     * @param string $city
     * @return $this
     */
    public function setCity(string $city): self
    {
        $this->city = $city;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getZip(): ?string
    {
        return $this->zip;
    }

    /**
     * @param string $zip
     * @return $this
     */
    public function setZip(string $zip): self
    {
        $this->zip = $zip;
        return $this;
    }

    /**
     * @return School|null
     */
    public function getSchool(): ?School
    {
        return $this->school;
    }

    /**
     * @param School|null $school
     * @return $this
     */
    public function setSchool(?School $school): self
    {
        $this->school = $school;
        return $this;
    }

    /**
     * @return Collection|Period[]
     */
    public function getPeriods(): Collection
    {
        return $this->periods;
    }

    /**
     * @param Period $period
     * @return $this
     */
    public function addPeriod(Period $period): self
    {
        if (!$this->periods->contains($period)) {
            $this->periods[] = $period;
            $period->setImplantation($this);
        }

        return $this;
    }

    /**
     * @param Period $period
     * @return $this
     */
    public function removePeriod(Period $period): self
    {
        if ($this->periods->removeElement($period)) {
            // set the owning side to null (unless already changed)
            if ($period->getImplantation() === $this) {
                $period->setImplantation(null);
            }
        }

        return $this;
    }
}
