<?php

namespace App\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\CommandeRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\SerializedName;

#[ORM\Entity(repositoryClass: CommandeRepository::class)]
#[ApiResource(
    attributes:[
        "pagination_enabled"=>true,
        "pagination_items_per_page"=>3
            ],

    itemOperations: [
        "put" => [
            // Securuté globale dans une ressource 
            "security" => "is_granted('ROLE_GESTIONNAIRE')",
            "security_message" => "Vous n'avez pas access à cette Ressource",

        ], "get" => [], "delete"
    ],
    collectionOperations: [
        "post" => [

        'denormalization_context' => ['groups' => ["commande:write"]],
        ],
        "get" => [
            'normalization_context' => ['groups' => ['commande:read']],
        ],

    ]
)]

class Commande
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $etatCmd = "commande";

    // #[Groups(['commande:read'])]
    #[ORM\Column(type: 'string')]
    private $numCmd;

    // #[Groups(["commande:write"])]

    // #[Groups(['commande:read'])]
    #[ORM\Column(type: 'datetime')]
    private $dateCmd;

    // #[Groups(["commande:write"])]
    #[ORM\Column(type: 'string', length: 255)]
    private $etatPaiement = "non";

    // #[ORM\Column(type: 'integer')]
    // private $paiement;
    // #[Groups(["commande:write"])]
    // #[ORM\Column(type: 'string', length: 100)]
    // private $telLivraison; 


    // #[ApiSubresource]
    // #[Groups(['commande:read'])]
    #[ORM\ManyToOne(targetEntity: Client::class, inversedBy: 'commandes')]
    private $client;

    // #[ORM\ManyToMany(targetEntity: Produit::class, inversedBy: 'commandes')]
    // private $produits;

    #[ORM\ManyToOne(targetEntity: Livraison::class, inversedBy: 'commandes')]
    private $livraison;

    // #[ORM\OneToMany(mappedBy: 'commande', targetEntity: LigneCommande::class)]
    // private $ligneDeCmd;
    // #[Groups(["commande:write"])]
    // #[ORM\ManyToOne(targetEntity: Zone::class, inversedBy: 'commandes')]
    // private $zone;

    #[ORM\ManyToOne(targetEntity: Gestionnaire::class, inversedBy: 'commandes')]
    private $gestionnaire;

    // #[Groups(["commande:write"])]
    // #[ORM\ManyToMany(targetEntity: Produit::class, mappedBy: 'commandes')]
    // private $produits;

    // #[Groups(['commande:read'])]
    #[ORM\OneToMany(mappedBy: 'commande', targetEntity: LigneCommande::class,cascade: ["persist"])]
    #[Groups(["commande:write","commande:read"])]
    #[SerializedName("Produits")]
    private $ligneCommandes;

    public function __construct()
    {
        // $this->produits = new ArrayCollection();
        $this->dateCmd = new \DateTime();
        $this->ligneCommandes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEtatCmd(): ?string
    {
        return $this->etatCmd;
    }

    public function setEtatCmd(string $etatCmd): self
    {
        $this->etatCmd = $etatCmd;

        return $this;
    }

    public function getNumCmd(): ?string
    {
        return $this->numCmd;
    }

    public function setNumCmd(string $numCmd): self
    {
        $this->numCmd = $numCmd;

        return $this;
    }

    public function getDateCmd(): ?\DateTimeInterface
    {
        return $this->dateCmd;
    }

    public function setDateCmd(\DateTimeInterface $dateCmd): self
    {
        $this->dateCmd = $dateCmd;

        return $this;
    }

    public function getEtatPaiement(): ?string
    {
        return $this->etatPaiement;
    }

    public function setEtatPaiement(string $etatPaiement): self
    {
        $this->etatPaiement = $etatPaiement;

        return $this;
    }

    // public function getPaiement(): ?int
    // {
    //     return $this->paiement;
    // }

    // public function setPaiement(int $paiement): self
    // {
    //     $this->paiement = $paiement;

    //     return $this;
    // }

    // public function getTelLivraison(): ?string
    // {
    //     return $this->telLivraison;
    // }

    // public function setTelLivraison(string $telLivraison): self
    // {
    //     $this->telLivraison = $telLivraison;

    //     return $this;
    // }



    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(?Client $client): self
    {
        $this->client = $client;

        return $this;
    }



    public function getLivraison(): ?Livraison
    {
        return $this->livraison;
    }

    public function setLivraison(?Livraison $livraison): self
    {
        $this->livraison = $livraison;

        return $this;
    }


    // public function getZone(): ?Zone
    // {
    //     return $this->zone;
    // }

    // public function setZone(?Zone $zone): self
    // {
    //     $this->zone = $zone;

    //     return $this;
    // }

    public function getGestionnaire(): ?Gestionnaire
    {
        return $this->gestionnaire;
    }

    public function setGestionnaire(?Gestionnaire $gestionnaire): self
    {
        $this->gestionnaire = $gestionnaire;

        return $this;
    }

    // /**
    //  * @return Collection<int, Produit>
    //  */
    // public function getProduits(): Collection
    // {
    //     return $this->produits;
    // }

    // public function addProduit(Produit $produit): self
    // {
    //     if (!$this->produits->contains($produit)) {
    //         $this->produits[] = $produit;
    //         $produit->addCommande($this);
    //     }

    //     return $this;
    // }

    // public function removeProduit(Produit $produit): self
    // {
    //     if ($this->produits->removeElement($produit)) {
    //         $produit->removeCommande($this);
    //     }

    //     return $this;
    // }

    /**
     * @return Collection<int, LigneCommande>
     */
    public function getLigneCommandes(): Collection
    {
        return $this->ligneCommandes;
    }

    public function addLigneCommande(LigneCommande $ligneCommande): self
    {
        if (!$this->ligneCommandes->contains($ligneCommande)) {
            $this->ligneCommandes[] = $ligneCommande;
            $ligneCommande->setCommande($this);
        }

        return $this;
    }

    public function removeLigneCommande(LigneCommande $ligneCommande): self
    {
        if ($this->ligneCommandes->removeElement($ligneCommande)) {
            // set the owning side to null (unless already changed)
            if ($ligneCommande->getCommande() === $this) {
                $ligneCommande->setCommande(null);
            }
        }

        return $this;
    }
}
