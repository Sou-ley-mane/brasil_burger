<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\ProduitRepository;
use Doctrine\Common\Collections\Collection;
// use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiResource;
use phpDocumentor\Reflection\Types\Nullable;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\SerializedName;
use Symfony\Component\Validator\Constraints as Assert;
// use Symfony\Component\Validator\Validator\ValidatorInterface;


#[ORM\InheritanceType("JOINED")]
#[ORM\DiscriminatorColumn(name: "type", type: "string")]
#[ORM\DiscriminatorMap([
    "burger" => "Burger",
    "menu" => "Menu",
    "boisson" => "Boisson",
    "frite" => "Frites"
])]

#[ORM\Entity(repositoryClass: ProduitRepository::class)]
#[ApiResource(

    collectionOperations: [
        "get" => [
            'normalization_context' => ['groups' => ["produit:read"]],
        ],

        "post",

    ],
    itemOperations: [
        "put",
        "get" => [
            'normalization_context' => [
                'groups' => ['get1produit']
            ]

        ], "delete"
    ]
)]


class Produit
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(
        [
            'produit:read:burger',
            "produit:read:boisson",
            "produit:read:frite",
            'produit:read',
            'produit:catalogue:read',
            'produit:complement:read',
            'produit:menu:read',
            'produit:menu:lecture',
            'get1produit',
            'commande:read',
        'commande:lecture'
        ]
    )]
    protected $id;



    #[ORM\Column(type: 'string', length: 255)]
    #[Groups([
        "produit:write:burger", 'produit:read:burger', "produit:write:boisson",
        "produit:read:boisson",
        "produit:write:frite",
        "produit:read:frite",
        'produit:catalogue:read',
        'produit:complement:read',
        'produit:menu:lecture',
        'produit:menuBurger:lecture',
        'produit:menuFrite:lecture',
        // #[Assert\NotBlank(message:"Le nom du produit  est Obligatoire")]
        'produit:menuTaille:lecture',
        'get1produit',
        'commande:read',
        'commande:lecture',
        'personne:client:read',
        'personne:client:lecture',
        'produit:read'

    ])]
    protected $nomProduit;




    // #[Assert\NotBlank(message:"Le prix du produit  est Obligatoire")]
    #[Groups([
        "produit:write:burger", 'produit:read:burger',
        "produit:write:boisson",
        "produit:read:boisson",
        "produit:write:frite",
        "produit:read:frite",
        'produit:catalogue:read',
        'produit:complement:read',
        'produit:menu:lecture',
        'get1produit',
        'commande:read',
        'commande:lecture',
        'personne:client:read',
        'personne:client:lecture',
        'produit:read'
    ])]
    #[ORM\Column(type: 'integer')]
    protected $prix;


    #[ORM\Column(type: 'string', length: 255)]
    protected $etatProduit = "true";


    #[ORM\ManyToOne(targetEntity: Gestionnaire::class, inversedBy: 'produits')]
    private $gestionnaire;



    #[ORM\OneToMany(mappedBy: 'produit', targetEntity: LigneCommande::class)]
    private $ligneCommandes;

    #[Groups(['produit:read:burger', 
    "produit:read:boisson", 
    "produit:read:frite", 
    'produit:menu:read', 
    'produit:catalogue:read', 
    'produit:menu:lecture',
    'get1produit',
    'personne:client:read',
    'personne:client:lecture',
    'produit:read',
    'produit:complement:read'])]
    #[ORM\Column(type: 'blob', nullable: true)]
    private $image;


    #[Groups(["produit:write:burger", "produit:write:boisson", "produit:write:frite"])]
    #[SerializedName("image")]
    private $plainimage;


    public function __construct()
    {

        $this->ligneCommandes = new ArrayCollection();
    }



    public function getId(): ?int
    {
        return $this->id;
    }



    public function getNomProduit(): ?string
    {
        return $this->nomProduit;
    }

    public function setNomProduit(string $nomProduit): self
    {
        $this->nomProduit = $nomProduit;

        return $this;
    }

    public function getPrix(): ?int
    {
        return $this->prix;
    }

    public function setPrix(int $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    public function getEtatProduit(): ?string
    {
        return $this->etatProduit;
    }

    public function setEtatProduit(string $etatProduit): self
    {
        $this->etatProduit = $etatProduit;

        return $this;
    }

    public function getGestionnaire(): ?Gestionnaire
    {
        return $this->gestionnaire;
    }

    public function setGestionnaire(?Gestionnaire $gestionnaire): self
    {
        $this->gestionnaire = $gestionnaire;

        return $this;
    }

    /**
     * @return Collection<int, Commande>
     */
    // public function getCommandes(): Collection
    // {
    //     return $this->commandes;
    // }

    // public function addCommande(Commande $commande): self
    // {
    //     if (!$this->commandes->contains($commande)) {
    //         $this->commandes[] = $commande;
    //     }

    //     return $this;
    // }

    // public function removeCommande(Commande $commande): self
    // {
    //     $this->commandes->removeElement($commande);

    //     return $this;
    // }



    public function addLigneCommande(LigneCommande $ligneCommande): self
    {
        if (!$this->ligneCommandes->contains($ligneCommande)) {
            $this->ligneCommandes[] = $ligneCommande;
            $ligneCommande->setProduit($this);
        }

        return $this;
    }

    public function removeLigneCommande(LigneCommande $ligneCommande): self
    {
        if ($this->ligneCommandes->removeElement($ligneCommande)) {
            // set the owning side to null (unless already changed)
            if ($ligneCommande->getProduit() === $this) {
                $ligneCommande->setProduit(null);
            }
        }

        return $this;
    }



    public function getPlainimage(): ?string
    {
        return $this->plainimage;
    }

    public function setPlainimage(?string $plainimage): self
    {
        $this->plainimage = $plainimage;

        return $this;
    }

    public function getImage()
    {
        // dd();
        return (is_resource($this->image) ? utf8_encode(base64_encode(stream_get_contents($this->image))) : $this->image);
        //   base64_encode(stream_get_contents($this->image)) ;
    }

    public function setImage($image): self
    {
        $this->image = $image;

        return $this;
    }
}
