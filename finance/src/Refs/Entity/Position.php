<?php

namespace App\Refs\Entity;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Refs\Repository\Repo\PositionRepository")
 */
class Position
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $descriprion;

    /**
     * @ORM\OneToMany(targetEntity="App\Refs\Entity\Vacancy", mappedBy="position", orphanRemoval=true)
     */
    private $vacancies;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDescriprion(): ?string
    {
        return $this->descriprion;
    }

    public function setDescriprion(?string $descriprion): self
    {
        $this->descriprion = $descriprion;

        return $this;
    }

    /**
     * @return Collection|Vacancy[]
     */
    public function getVacancies(): Collection
    {
        return $this->vacancies;
    }
}
