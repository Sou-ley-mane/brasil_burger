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
           
            ]
)]
#[ORM\Entity(repositoryClass: ZoneRepository::class)]
class Zone
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;
    #[Groups(["zone:write"])]
    #[ORM\Column(type: 'string', length: 255)]
    private $nomZone;


    #[Groups(["zone:write"])]
    #[ORM\Column(type: 'string', length: 255)]
    private $etatZone;

    #[Groups(["zone:write"])]
    #[ORM\Column(type: 'integer')]
    private $coutLivraison;

    #[ORM\OneToMany(mappedBy: 'zone', targetEntity: Livraison::class)]
    private $livraisons;

    #[ORM\OneToMany(mappedBy: 'zone', targetEntity: Quartier::class)]
    private $quartiers;

   

    public function __construct()
    {
        $this->livraisons = new ArrayCollection();
        $this->quartiers = new ArrayCollection();
       
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

 



  
}
