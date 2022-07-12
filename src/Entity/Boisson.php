<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\BoissonRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
// use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: BoissonRepository::class)]
#[ApiResource(
    attributes:[
        // Securuté globale dans une ressource 
        // "security" => "is_granted('ROLE_GESTIONNAIRE')",
        // "security_message"=>"Vous n'avez pas access à cette Ressource",
    ],
    collectionOperations:["get"=>[
        'normalization_context' => ['groups' => ["produit:read:boisson"]]

    ]
    ,"post"=>[
        'denormalization_context' => ['groups' => ["produit:write:boisson"]]
    ]],
    itemOperations:["put","get","delete"]

)]
class Boisson extends Produit
{
    
  #[Groups(["produit:write:boisson","produit:read:boisson"])]
    #[ORM\ManyToMany(targetEntity: TailleBoisson::class, mappedBy: 'boissons',cascade:["persist"])]
    private $tailleBoissons;

    public function __construct()
    {
       
        $this->tailleBoissons = new ArrayCollection();
    }



 

  

    /**
     * @return Collection<int, TailleBoisson>
     */
    public function getTailleBoissons(): Collection
    {
        return $this->tailleBoissons;
    }

    public function addTailleBoisson(TailleBoisson $tailleBoisson): self
    {
        if (!$this->tailleBoissons->contains($tailleBoisson)) {
            $this->tailleBoissons[] = $tailleBoisson;
            $tailleBoisson->addBoisson($this);
        }

        return $this;
    }

    public function removeTailleBoisson(TailleBoisson $tailleBoisson): self
    {
        if ($this->tailleBoissons->removeElement($tailleBoisson)) {
            $tailleBoisson->removeBoisson($this);
        }

        return $this;
    }
}
