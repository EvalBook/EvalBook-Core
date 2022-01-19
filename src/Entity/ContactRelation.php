<?php

namespace EvalBookCore\Entity;

use EvalBookCore\Repository\ContactRelationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use JetBrains\PhpStorm\Pure;

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
