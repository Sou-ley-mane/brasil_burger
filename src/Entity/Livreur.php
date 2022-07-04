<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\LivreurRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: LivreurRepository::class)]
#[ApiResource(
    attributes:[
        // Securuté globale dans une ressource 
        "security" => "is_granted('ROLE_GESTIONNAIRE')",
        "security_message"=>"Vous n'avez pas access à cette Ressource",
    ],
    collectionOperations:["get"=>[
        'normalization_context' => ['groups' => ['personne:livreur:read']]
    ],"post"],
    itemOperations:["put","get"]
)]
class Livreur extends User
{
   
    #[Groups(['personne:livreur:read'])]
    #[ORM\Column(type: 'string', length: 255)]
    private $matricule;

    #[Groups(['personne:livreur:read'])]
    #[ORM\Column(type: 'string', length: 255)]
    private $telephoneLivreur;

  

    #[ORM\OneToMany(mappedBy: 'livreur', targetEntity: Livraison::class)]
    private $livraisons;

    #[ORM\ManyToOne(targetEntity: Gestionnaire::class, inversedBy: 'livreurs')]
    private $gestionnaire;

    public function __construct()
    {
        $this->livraisons = new ArrayCollection();
    }

  

 

    public function getMatricule(): ?string
    {
        return $this->matricule;
    }

    public function setMatricule(string $matricule): self
    {
        $this->matricule = $matricule;

        return $this;
    }

    public function getTelephoneLivreur(): ?string
    {
        return $this->telephoneLivreur;
    }

    public function setTelephoneLivreur(string $telephoneLivreur): self
    {
        $this->telephoneLivreur = $telephoneLivreur;

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
            $livraison->setLivreur($this);
        }

        return $this;
    }

    public function removeLivraison(Livraison $livraison): self
    {
        if ($this->livraisons->removeElement($livraison)) {
            // set the owning side to null (unless already changed)
            if ($livraison->getLivreur() === $this) {
                $livraison->setLivreur(null);
            }
        }

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

 
}
