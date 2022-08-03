<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\MenuPortionFriteRepository;
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
            'normalization_context' => ['groups' => ['produit:menuFrite:read']]
        ],
        "post"=>[
            'denormalization_context' => ['groups' => ["produit:write:menuFrite"]]
        ]
     ],
     itemOperations:["put","get"=>[
        'normalization_context' => ['groups' => ['produit:menuFrite:lecture']]

     ],"delete"]
)]
#[ORM\Entity(repositoryClass: MenuPortionFriteRepository::class)]
class MenuPortionFrite
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[Groups(["produit:write:menu",'produit:menu:lecture','produit:menu:read','produit:menuFrite:lecture'])]
    #[ORM\Column(type: 'integer')]
    private $quantite;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $prix;

    #[ORM\ManyToOne(targetEntity: Menu::class, inversedBy: 'menuPortionFrites')]
    private $menus;

#[Groups(["produit:write:menu",'produit:menu:read','produit:menu:lecture','produit:menuFrite:lecture'])]
    #[ORM\ManyToOne(targetEntity: Frites::class, inversedBy: 'menuPortionFrites')]
    private $frite;

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

    public function getPrix(): ?int
    {
        return $this->prix;
    }

    public function setPrix(?int $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    public function getMenus(): ?Menu
    {
        return $this->menus;
    }

    public function setMenus(?Menu $menus): self
    {
        $this->menus = $menus;

        return $this;
    }

    public function getFrite(): ?Frites
    {
        return $this->frite;
    }

    public function setFrite(?Frites $frite): self
    {
        $this->frite = $frite;

        return $this;
    }
}
