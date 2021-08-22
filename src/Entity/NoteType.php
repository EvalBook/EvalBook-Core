<?php

namespace App\Entity;

use App\Repository\NoteTypeRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=NoteTypeRepository::class)
 */
class NoteType
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
     * @ORM\Column(type="integer")
     */
    private int $coefficient;


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
     * @return int|null
     */
    public function getCoefficient(): ?int
    {
        return $this->coefficient;
    }

    /**
     * @param int $coefficient
     * @return $this
     */
    public function setCoefficient(int $coefficient): self
    {
        $this->coefficient = $coefficient;
        return $this;
    }
}
