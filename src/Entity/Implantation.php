<?php

namespace App\Entity;

use App\Repository\ImplantationRepository;
use Doctrine\ORM\Mapping as ORM;

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
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $street;

    /**
     * @ORM\Column(type="smallint")
     */
    private $number;

    /**
     * @ORM\Column(type="smallint")
     */
    private $zip;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $country;

    /**
     * @ORM\ManyToOne(targetEntity=School::class, inversedBy="implantations")
     * @ORM\JoinColumn(nullable=false)
     */
    private $school;

    /**
     * Return the Implantation ID.
     * @return int|null
     */
    public function getId(): ?int {
        return $this->id;
    }

    /**
     * Return the Implantation name.
     * @return string|null
     */
    public function getName(): ?string {
        return $this->name;
    }

    /**
     * Set the Implantation name.
     * @param string $name
     * @return $this
     */
    public function setName(string $name): self {
        $this->name = $name;

        return $this;
    }

    /**
     * Return the Implantation street.
     * @return string|null
     */
    public function getStreet(): ?string {
        return $this->street;
    }

    /**
     * Set the Implantation Street.
     * @param string $street
     * @return $this
     */
    public function setStreet(string $street): self {
        $this->street = $street;

        return $this;
    }

    /**
     * Return the Implantation number.
     * @return int|null
     */
    public function getNumber(): ?int {
        return $this->number;
    }

    /**
     * Set the Implantation number.
     * @param int $number
     * @return $this
     */
    public function setNumber(int $number): self {
        $this->number = $number;

        return $this;
    }

    /**
     * Return the Implantation country postal code.
     * @return int|null
     */
    public function getZip(): ?int {
        return $this->zip;
    }

    /**
     * Set the Implantation postal code.
     * @param int $zip
     * @return $this
     */
    public function setZip(int $zip): self {
        $this->zip = $zip;

        return $this;
    }

    /**
     * Return the Implantation country.
     * @return string|null
     */
    public function getCountry(): ?string {
        return $this->country;
    }

    /**
     * Set the Implantation Country.
     * @param string $country
     * @return $this
     */
    public function setCountry(string $country): self {
        $this->country = $country;

        return $this;
    }

    /**
     * Return the Implantation's School.
     * @return School|null
     */
    public function getSchool(): ?School {
        return $this->school;
    }

    /**
     * Set the Implantation's School.
     * @param School|null $school
     * @return $this
     */
    public function setSchool(?School $school): self {
        $this->school = $school;

        return $this;
    }

    /**
     * The Implantation's string representation.
     * @return string
     */
    public function __toString(): string {
        return $this->getName();
    }
}
