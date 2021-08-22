<?php

namespace App\Entity;

use App\Repository\SchoolRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use JetBrains\PhpStorm\Pure;

/**
 * @ORM\Entity(repositoryClass=SchoolRepository::class)
 */
class School
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
     * @ORM\Column(type="smallint")
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
     * @ORM\OneToMany(targetEntity=Implantation::class, mappedBy="school")
     */
    private ArrayCollection $implantations;



    public function __construct()
    {
        $this->implantations = new ArrayCollection();
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
     * @return Collection|Implantation[]
     */
    public function getImplantations(): Collection
    {
        return $this->implantations;
    }

    /**
     * @param Implantation $implantation
     * @return $this
     */
    public function addImplantation(Implantation $implantation): self
    {
        if (!$this->implantations->contains($implantation)) {
            $this->implantations[] = $implantation;
            $implantation->setSchool($this);
        }

        return $this;
    }

    /**
     * @param Implantation $implantation
     * @return $this
     */
    public function removeImplantation(Implantation $implantation): self
    {
        if ($this->implantations->removeElement($implantation)) {
            // set the owning side to null (unless already changed)
            if ($implantation->getSchool() === $this) {
                $implantation->setSchool(null);
            }
        }

        return $this;
    }
}
