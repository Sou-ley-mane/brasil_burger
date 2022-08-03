<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\MenuTailleBoissonRepository;
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
            'normalization_context' => ['groups' => ['produit:menuTaille:read']]
        ],
        "post"=>[
            'denormalization_context' => ['groups' => ["produit:write:menuTaille"]]
        ]
     ],
     itemOperations:["put","get"=>[
        'normalization_context' => ['groups' => ['produit:menuTaille:lecture']]

     ],"delete"]
)]
#[ORM\Entity(repositoryClass: MenuTailleBoissonRepository::class)]
class MenuTailleBoisson
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    
    #[ORM\Column(type: 'integer')]
    // #[Groups(["produit:write:menu",'produit:menu:read','produit:menu:lecture','produit:menuTaille:lecture'])]
    private $id;

    #[Groups(["produit:write:menu",'produit:menu:read','produit:menu:lecture','produit:menuTaille:read','produit:menuTaille:lecture'])]
    #[ORM\Column(type: 'integer')]
    private $quantite;

    #[Groups(['produit:menu:read','produit:menu:lecture'])]
    #[ORM\Column(type: 'integer', nullable: true)]
    private $prix;

    #[ORM\ManyToOne(targetEntity: Menu::class, inversedBy: 'menuTailleBoissons')]
    private $menu;
    
    #[Groups(["produit:write:menu",'produit:menu:read','produit:menu:lecture','produit:menuTaille:lecture'])]
    #[ORM\ManyToOne(targetEntity: TailleBoisson::class, inversedBy: 'menuTailleBoissons')]
    private $tailleBoisson;

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

    public function getMenu(): ?Menu
    {
        return $this->menu;
    }

    public function setMenu(?Menu $menu): self
    {
        $this->menu = $menu;

        return $this;
    }

    public function getTailleBoisson(): ?TailleBoisson
    {
        return $this->tailleBoisson;
    }

    public function setTailleBoisson(?TailleBoisson $tailleBoisson): self
    {
        $this->tailleBoisson = $tailleBoisson;

        return $this;
    }
}
