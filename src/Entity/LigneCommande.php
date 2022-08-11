<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\LigneCommandeRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: LigneCommandeRepository::class)]
// #[ApiResource()]

class LigneCommande
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    // #[Groups(["commande:write"])]

    private $id;

    // #[Groups(["commande:write"])]
    #[Groups(["commande:write",
    'commande:read',
    'commande:lecture',
    'personne:client:read',
    'personne:client:lecture'
    ])]
    #[ORM\Column(type: 'integer', nullable: true)]
    private $quantite;
    
    #[Groups(["commande:write",
    'commande:read',
    'commande:lecture',
    'personne:client:read',
    'personne:client:lecture'])]
    #[ORM\ManyToOne(targetEntity: Produit::class, inversedBy: 'ligneCommandes')]
    private $produit;

    #[ORM\ManyToOne(targetEntity: Commande::class, inversedBy: 'ligneCommandes')]
    // #[Groups(["commande:write"])]
    private $commande;

    #[Groups(['commande:read','commande:lecture', 'personne:client:read',
    'personne:client:lecture'])]
    #[ORM\Column(type: 'integer', nullable: true)]
    private $prix;



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuantite(): ?int
    {
        return $this->quantite;
    }

    public function setQuantite(?int $quantite): self
    {
        $this->quantite = $quantite;

        return $this;
    }

    public function getProduit(): ?Produit
    {
        return $this->produit;
    }

    public function setProduit(?Produit $produit): self
    {
        $this->produit = $produit;

        return $this;
    }

    public function getCommande(): ?Commande
    {
        return $this->commande;
    }

    public function setCommande(?Commande $commande): self
    {
        $this->commande = $commande;

        return $this;
    }

    public function getPrix(): ?int
    {
        return $this->prix;
    }

    public function setPrix(?int $prix): self
    {
        $this->prix = $prix;

        return $this;
    }



  }

  

