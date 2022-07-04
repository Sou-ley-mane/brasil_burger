<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\BurgerRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use ApiPlatform\Core\Annotation\ApiResource;

    
#[ORM\Entity(repositoryClass: BurgerRepository::class)]
#[ApiResource(
    attributes:[
        // Securuté globale dans une ressource 
        "security" => "is_granted('ROLE_GESTIONNAIRE')",
        "security_message"=>"Vous n'avez pas access à cette Ressource",
    ],

    itemOperations:["put","get" =>[],"delete"
],
    collectionOperations:[
        "post"=>[
             
            'denormalization_context' => ['groups' => ["produit:write:burger"]]
        ],
        "get"=>[
            'normalization_context' => ['groups' => ['produit:read:burger']],],
        
            ]
        
)]
class Burger extends Produit
{
    #[ORM\ManyToMany(targetEntity: Menu::class, mappedBy: 'burgers')]
    private $menus;

    public function __construct()
    {
        $this->menus = new ArrayCollection();
    }

    /**
     * @return Collection<int, Menu>
     */
    public function getMenus(): Collection
    {
        return $this->menus;
    }

    public function addMenu(Menu $menu): self
    {
        if (!$this->menus->contains($menu)) {
            $this->menus[] = $menu;
            $menu->addBurger($this);
        }

        return $this;
    }

    public function removeMenu(Menu $menu): self
    {
        if ($this->menus->removeElement($menu)) {
            $menu->removeBurger($this);
        }

        return $this;
    }
}
