<?php

namespace App\Entity;

use App\Repository\ContactRelationRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ContactRelationRepository::class)
 */
class ContactRelation
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
    private string $relation_name;


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
    public function getRelationName(): ?string
    {
        return $this->relation_name;
    }

    /**
     * @param string $relation_name
     * @return $this
     */
    public function setRelationName(string $relation_name): self
    {
        $this->relation_name = $relation_name;
        return $this;
    }
}
