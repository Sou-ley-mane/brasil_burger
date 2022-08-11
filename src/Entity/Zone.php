<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\ZoneRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
#[ApiResource(
    collectionOperations:[
        "post"=>[
         // 'denormalization_context' => ['groups' => ["produit:write"]]
            'denormalization_context' => ['groups' => ["zone:write"]]
        ],
        "get"=>[
            'normalization_context' => ['groups' => ['zone:read']],],
           
        ],
        itemOperations: [
            "put",
            "get" => [
                'normalization_context' => [
                    'groups' => ['zone:lecture']
                ]
    
            ], "delete"
        ]
)]
#[ORM\Entity(repositoryClass: ZoneRepository::class)]
class Zone
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(["commande:read","commande:lecture", 'zone:read','zone:lecture'])]
    private $id;


    #[Groups(["zone:write",
    'zone:read',
    "commande:read",
    "commande:lecture",
    'personne:client:read',
    'personne:client:lecture'])]
    #[ORM\Column(type: 'string', length: 255)]
    private $nomZone;


    #[Groups(["zone:write",'zone:read'])]
    #[ORM\Column(type: 'string', length: 255)]
    private $etatZone;

    #[Groups([
    "commande:read",
    "commande:lecture",
    'personne:client:read',
    'personne:client:lecture',
    'zone:read','zone:lecture'])]
    #[ORM\Column(type: 'integer')]
    private $coutLivraison;

    #[ORM\OneToMany(mappedBy: 'zone', targetEntity: Livraison::class)]
    private $livraisons;

    #[ORM\OneToMany(mappedBy: 'zone', targetEntity: Quartier::class)]
    private $quartiers;

    #[Groups([
        'zone:read',
        'zone:lecture'
         ])]
    #[ORM\OneToMany(mappedBy: 'zone', targetEntity: Commande::class)]
    private Collection $commandes;

   

    public function __construct()
    {
        $this->livraisons = new ArrayCollection();
        $this->quartiers = new ArrayCollection();
        $this->commandes = new ArrayCollection();
       
    }



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomZone(): ?string
    {
        return $this->nomZone;
    }

    public function setNomZone(string $nomZone): self
    {
        $this->nomZone = $nomZone;

        return $this;
    }

    public function getEtatZone(): ?string
    {
        return $this->etatZone;
    }

    public function setEtatZone(string $etatZone): self
    {
        $this->etatZone = $etatZone;

        return $this;
    }

    public function getCoutLivraison(): ?int
    {
        return $this->coutLivraison;
    }

    public function setCoutLivraison(int $coutLivraison): self
    {
        $this->coutLivraison = $coutLivraison;

        return $this;
    }

    /**
     * @return Collection<int, Livraison>
     */
    public function getLivraisons(): Collection
    {
        return $this->livraisons;
    }

    public function addLivraison(Livraison $livraison): self
    {
        if (!$this->livraisons->contains($livraison)) {
            $this->livraisons[] = $livraison;
            $livraison->setZone($this);
        }

        return $this;
    }

    public function removeLivraison(Livraison $livraison): self
    {
        if ($this->livraisons->removeElement($livraison)) {
            // set the owning side to null (unless already changed)
            if ($livraison->getZone() === $this) {
                $livraison->setZone(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Quartier>
     */
    public function getQuartiers(): Collection
    {
        return $this->quartiers;
    }

    public function addQuartier(Quartier $quartier): self
    {
        if (!$this->quartiers->contains($quartier)) {
            $this->quartiers[] = $quartier;
            $quartier->setZone($this);
        }

        return $this;
    }

    public function removeQuartier(Quartier $quartier): self
    {
        if ($this->quartiers->removeElement($quartier)) {
            // set the owning side to null (unless already changed)
            if ($quartier->getZone() === $this) {
                $quartier->setZone(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Commande>
     */
    public function getCommandes(): Collection
    {
        return $this->commandes;
    }

    public function addCommande(Commande $commande): self
    {
        if (!$this->commandes->contains($commande)) {
            $this->commandes->add($commande);
            $commande->setZone($this);
        }

        return $this;
    }

    public function removeCommande(Commande $commande): self
    {
        if ($this->commandes->removeElement($commande)) {
            // set the owning side to null (unless already changed)
            if ($commande->getZone() === $this) {
                $commande->setZone(null);
            }
        }

        return $this;
    }

 



  
}
