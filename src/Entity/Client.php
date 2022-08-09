<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\ClientRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
#[ApiResource(
    attributes:[
        // Securuté globale dans une ressource 
        // "security" => "is_granted('ROLE_GESTIONNAIRE')",
        // "security_message"=>"Vous n'avez pas access à cette Ressource",
    ],
    collectionOperations:[
        
        "get"=>[
            'normalization_context' => ['groups' => ['personne:client:read']]
    ]
    ,"post"=>[
        'denormalization_context' => ['groups' => ['personne:client:write']]

    ]
],
    itemOperations:["put","get"=>[
        'normalization_context' => ['groups' => ['personne:client:lecture']]

    ],"delete"=>[
        // //Securité d'une opération
        // "security"=>"is_granted('ROLE_GESTIONNAIRE')",
        // "security"=>"Votre profile ne vous permet pas d'effectuer une suppression"
    ]]
)]
#[ORM\Entity(repositoryClass: ClientRepository::class)]
class Client extends User
{ 
   
    #[Groups([
        'personne:client:write',
        'personne:client:read',
        'personne:client:lecture'
        
        ])]
    #[ORM\Column(type: 'string', length: 255)]
    private $adresse;
    
    #[Groups([
        'personne:client:write',
        'personne:client:read',
        'personne:client:lecture'
        ])]
    #[ORM\Column(type: 'string', length: 100)]
    private $telephone;
    
    #[ApiSubresource]
    #[Groups([
        'personne:client:write',
        'personne:client:read',
        'personne:client:lecture'
        ])]
    #[ORM\OneToMany(mappedBy: 'client', targetEntity: Commande::class)]
    private $commandes;

    public function __construct()
    {
        $this->commandes = new ArrayCollection();
    }

 
    
    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(string $telephone): self
    {
        $this->telephone = $telephone;

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
            $this->commandes[] = $commande;
            $commande->setClient($this);
        }

        return $this;
    }

    public function removeCommande(Commande $commande): self
    {
        if ($this->commandes->removeElement($commande)) {
            // set the owning side to null (unless already changed)
            if ($commande->getClient() === $this) {
                $commande->setClient(null);
            }
        }

        return $this;
    }

 

}

 

 

 

 

  
   

    

