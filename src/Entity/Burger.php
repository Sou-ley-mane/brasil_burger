<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\BurgerRepository;
use ApiPlatform\Core\Annotation\ApiFilter;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
    
#[ORM\Entity(repositoryClass: BurgerRepository::class)]
//Application de filtre
#[ApiFilter(SearchFilter::class, properties: ['id' => 'exact', 'prix' => 'exact'])]
#[ApiResource(
    attributes:[
        // Securuté globale dans une ressource 
        // "security" => "is_granted('ROLE_GESTIONNAIRE')",
        // "security_message"=>"Vous n'avez pas access à cette Ressource",
    ],

    itemOperations:["put","get" =>[],"delete"
],
    collectionOperations:[
        "post"=>[
         // 'denormalization_context' => ['groups' => ["produit:write"]]
            'denormalization_context' => ['groups' => ["produit:write:burger"]]
        ],
        "get"=>[
            'normalization_context' => ['groups' => ['produit:read:burger']],
        ],
           

       
            ]
    )]
class Burger extends Produit
{
 
    // #[Groups(['produit:read:burger'])]
    #[ORM\OneToMany(mappedBy: 'burger', targetEntity: MenuBurger::class)]
    private $menuBurgers;

    public function __construct()
    {
        $this->menuBurgers = new ArrayCollection();
    }

    /**
   
     * @return Collection<int, MenuBurger>
     */
    public function getMenuBurgers(): Collection
    {
        return $this->menuBurgers;
    }

    public function addMenuBurger(MenuBurger $menuBurger): self
    {
        if (!$this->menuBurgers->contains($menuBurger)) {
            $this->menuBurgers[] = $menuBurger;
            $menuBurger->setBurger($this);
        }

        return $this;
    }

    public function removeMenuBurger(MenuBurger $menuBurger): self
    {
        if ($this->menuBurgers->removeElement($menuBurger)) {
            // set the owning side to null (unless already changed)
            if ($menuBurger->getBurger() === $this) {
                $menuBurger->setBurger(null);
            }
        }

        return $this;
    }

 



 



 


}
