<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\QuartierRepository;
use ApiPlatform\Core\Annotation\ApiResource;

#[ORM\Entity(repositoryClass: QuartierRepository::class)]
#[ApiResource]
class Quartier
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $nomQartier;

    #[ORM\Column(type: 'boolean')]
    private $etatQartier;

    #[ORM\ManyToOne(targetEntity: Zone::class, inversedBy: 'quartiers')]
    private $zone;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomQartier(): ?string
    {
        return $this->nomQartier;
    }

    public function setNomQartier(string $nomQartier): self
    {
        $this->nomQartier = $nomQartier;

        return $this;
    }

    public function isEtatQartier(): ?bool
    {
        return $this->etatQartier;
    }

    public function setEtatQartier(bool $etatQartier): self
    {
        $this->etatQartier = $etatQartier;

        return $this;
    }

    public function getZone(): ?Zone
    {
        return $this->zone;
    }

    public function setZone(?Zone $zone): self
    {
        $this->zone = $zone;

        return $this;
    }

   
}
