<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\TailleBoissonRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: TailleBoissonRepository::class)]
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
            'normalization_context' => ['groups' => ['taille:read']]
        ],
        "post"=>[
            'denormalization_context' => ['groups' => ['taille:write']]
        ]
     ],
     itemOperations:["put","get"=>[
        'normalization_context' => ['groups' => ['taille:lecture']]

     ],"delete"]
)]

class TailleBoisson 
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups([
        'produit:complement:read',
        'produit:menu:lecture',
        'produit:menuTaille:lecture',
        'produit:menu:read',
        'taille:read',
        'taille:lecture'
        ])]
    private $id;
    // 
    #[Groups(['produit:complement:read','produit:menu:read','produit:menu:lecture','produit:menuTaille:lecture','taille:read','taille:lecture','get1produit','taille:write',"produit:read:boisson"])]
    #[ORM\Column(type: 'string', length: 255)]
    private $libelle;
    
    #[Groups(['produit:complement:read','produit:menu:read','produit:menu:lecture','produit:menuTaille:lecture','taille:read','taille:lecture','get1produit'])]
    #[ORM\ManyToMany(targetEntity: Boisson::class, inversedBy: 'tailleBoissons')]
    private $boissons;
    
    #[Groups([
        //     'produit:complement:read',
        //     'produit:menu:lecture',
        //     'produit:menuTaille:lecture',
            'produit:menu:read',
        //     'taille:read',
        //     'taille:lecture'
        ])]
    #[ORM\OneToMany(mappedBy: 'tailleBoisson', targetEntity: MenuTailleBoisson::class)]
    private $menuTailleBoissons;

    public function __construct()
    {
        $this->boissons = new ArrayCollection();
        $this->menuTailleBoissons = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): self
    {
        $this->libelle = $libelle;

        return $this;
    }

    /**
     * @return Collection<int, Boisson>
     */
    public function getBoissons(): Collection
    {
        return $this->boissons;
    }

    public function addBoisson(Boisson $boisson): self
    {
        if (!$this->boissons->contains($boisson)) {
            $this->boissons[] = $boisson;
        }

        return $this;
    }

    public function removeBoisson(Boisson $boisson): self
    {
        $this->boissons->removeElement($boisson);

        return $this;
    }

    /**
     * @return Collection<int, MenuTailleBoisson>
     */
    public function getMenuTailleBoissons(): Collection
    {
        return $this->menuTailleBoissons;
    }

    public function addMenuTailleBoisson(MenuTailleBoisson $menuTailleBoisson): self
    {
        if (!$this->menuTailleBoissons->contains($menuTailleBoisson)) {
            $this->menuTailleBoissons[] = $menuTailleBoisson;
            $menuTailleBoisson->setTailleBoisson($this);
        }

        return $this;
    }

    public function removeMenuTailleBoisson(MenuTailleBoisson $menuTailleBoisson): self
    {
        if ($this->menuTailleBoissons->removeElement($menuTailleBoisson)) {
            // set the owning side to null (unless already changed)
            if ($menuTailleBoisson->getTailleBoisson() === $this) {
                $menuTailleBoisson->setTailleBoisson(null);
            }
        }

        return $this;
    }
}
