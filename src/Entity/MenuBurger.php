<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\MenuBurgerRepository;
use Symfony\Component\Serializer\Annotation\Groups;
#[ApiResource( 
    attributes:[
        // Securuté globale dans une ressource 
        // "security" => "is_granted('ROLE_GESTIONNAIRE')",
        // "security_message"=>"Vous n'avez pas access à cette Ressource",
    ],
     collectionOperations:[
        // ****************************************
      

        // ******************************************
        "get"=>[
            'normalization_context' => ['groups' => ['produit:menuBurger:read']]
        ],
        "post"=>[
            'denormalization_context' => ['groups' => ["produit:write:menuBurger"]]
        ]
     ],
     itemOperations:["put","get"=>[
        'normalization_context' => ['groups' => ['produit:menuBurger:lecture']]

     ],"delete"]
)]
#[ORM\Entity(repositoryClass: MenuBurgerRepository::class)]
class MenuBurger
{
    
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[Groups(["produit:write:menu",'produit:menu:read','produit:menu:lecture','produit:menuBurger:read','produit:menuBurger:lecture'])]
    #[ORM\Column(type: 'integer')]
    private $quantite;
    
    #[Groups(["produit:write:menu",'produit:menu:read','produit:menu:lecture','produit:menuBurger:lecture'])]
    #[ORM\ManyToOne(targetEntity: Burger::class, inversedBy: 'menuBurgers')]
    private $burger;

    #[ORM\ManyToOne(targetEntity: Menu::class, inversedBy: 'menuBurgers')]
    private $menu;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuantite(): ?int
    {
        return $this->quantite;
    }

    public function setQuantite(int $quantite): self
    {
        $this->quantite = $quantite;

        return $this;
    }

    public function getBurger(): ?Burger
    {
        return $this->burger;
    }

    public function setBurger(?Burger $burger): self
    {
        $this->burger = $burger;

        return $this;
    }

    public function getMenu(): ?Menu
    {
        return $this->menu;
    }

    public function setMenu(?Menu $menu): self
    {
        $this->menu = $menu;

        return $this;
    }
}
