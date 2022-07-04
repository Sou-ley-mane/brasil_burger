<?php

namespace App\Entity;

use App\Entity\Burger;
use App\Entity\Frites;
use App\Entity\Boisson;
use App\Entity\Produit;
use Doctrine\ORM\Mapping as ORM;
use PhpParser\Node\Expr\FuncCall;
use App\Repository\MenuRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;

#[ApiResource( 
     collectionOperations:[
        "get"=>[
            'normalization_context' => ['groups' => ['produit:menu:read']]
        ],
        "post"
     ],
     itemOperations:["put","get"]
)]
#[ORM\Entity(repositoryClass: MenuRepository::class)]
class Menu extends Produit
{
    #[ORM\ManyToMany(targetEntity: Burger::class, inversedBy: 'menus')]
    private $burgers;

    #[ORM\ManyToMany(targetEntity: Frites::class, inversedBy: 'menus')]
    private $portionDeFrites;

    #[ORM\ManyToMany(targetEntity: Boisson::class, inversedBy: 'menus')]
    private $boissons;

    public function __construct()
    {
        $this->burgers = new ArrayCollection();
        $this->portionDeFrites = new ArrayCollection();
        $this->boissons = new ArrayCollection();
        
    }

    /**
     * @return Collection<int, Burger>
     */
    public function getBurgers(): Collection
    {
        return $this->burgers;
    }

    public function addBurger(Burger $burger): self
    {
        if (!$this->burgers->contains($burger)) {
            $this->burgers[] = $burger;
        }

        return $this;
    }

    public function removeBurger(Burger $burger): self
    {
        $this->burgers->removeElement($burger);

        return $this;
    }

    /**
     * @return Collection<int, Frites>
     */
    public function getPortionDeFrites(): Collection
    {
        return $this->portionDeFrites;
    }

    public function addPortionDeFrite(Frites $portionDeFrite): self
    {
        if (!$this->portionDeFrites->contains($portionDeFrite)) {
            $this->portionDeFrites[] = $portionDeFrite;
        }

        return $this;
    }

    public function removePortionDeFrite(Frites $portionDeFrite): self
    {
        $this->portionDeFrites->removeElement($portionDeFrite);

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

    public function prixTotalBurger($menu){
        $prix=0;
        $burgers=$menu->getBurgers();
        foreach ($burgers as $burger) {
            $prix+=$burger->getPrix();
        }
        return $prix;
    }

    public function prixTotalFrite($menu){
        $prix=0;
        $portionDeFrite=$menu->getPortionDeFrites();
        foreach ($portionDeFrite as $frite) {
            $prix+=$frite->getPrix();
        }
        return $prix;
    }
    public function prixTotalBoisson($menu){
        $prix=0;
        $boissons=$menu->getPortionDeFrites();
        foreach ( $boissons as  $boisson) {
            $prix+= $boisson->getPrix();
        }
        return $prix;
    }


    public function prixMenu($menuCommande){
        $totalBurger=$menuCommande->prixTotalBurger($menuCommande);
        $totalFrite=$menuCommande->prixTotalFrite($menuCommande);
        $totalBoisson=$menuCommande->prixTotalBoisson($menuCommande);
        return $totalBurger+$totalBoisson+$totalFrite;
    }
    
}
                  
    

    

    




