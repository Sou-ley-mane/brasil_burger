<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\FritesRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;

#[ORM\Entity(repositoryClass: FritesRepository::class)]
#[ApiResource(
    attributes:[
        // Securuté globale dans une ressource 
        "security" => "is_granted('ROLE_GESTIONNAIRE')",
        "security_message"=>"Vous n'avez pas access à cette Ressource",
    ],
    collectionOperations:["get"=>[
    'normalization_context' => ['groups' => ["produit:read:frite"]]

    ]
    ,"post"=>[
    'denormalization_context' => ['groups' => ["produit:write:frite"]]

    ]],
    itemOperations:["put","get","delete"]
)]
class Frites extends Produit{
  

    #[ORM\OneToMany(mappedBy: 'frite', targetEntity: MenuPortionFrite::class)]
    private $menuPortionFrites;

    public function __construct()
    {
        $this->menuPortionFrites = new ArrayCollection();
    }

    /**
     * @return Collection<int, MenuPortionFrite>
     */
    public function getMenuPortionFrites(): Collection
    {
        return $this->menuPortionFrites;
    }

    public function addMenuPortionFrite(MenuPortionFrite $menuPortionFrite): self
    {
        if (!$this->menuPortionFrites->contains($menuPortionFrite)) {
            $this->menuPortionFrites[] = $menuPortionFrite;
            $menuPortionFrite->setFrite($this);
        }

        return $this;
    }

    public function removeMenuPortionFrite(MenuPortionFrite $menuPortionFrite): self
    {
        if ($this->menuPortionFrites->removeElement($menuPortionFrite)) {
            // set the owning side to null (unless already changed)
            if ($menuPortionFrite->getFrite() === $this) {
                $menuPortionFrite->setFrite(null);
            }
        }

        return $this;
    }

 

  

   
}
