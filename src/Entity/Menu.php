<?php

namespace App\Entity;

use App\Entity\Burger;
use App\Entity\Frites;
use App\Entity\Boisson;
use App\Entity\Produit;
use Doctrine\ORM\Mapping as ORM;
use PhpParser\Node\Expr\FuncCall;
use App\Controller\MenuController;
use App\Repository\MenuRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

#[ApiResource( 
    attributes:[
        // Securuté globale dans une ressource 
        // "security" => "is_granted('ROLE_GESTIONNAIRE')",
        // "security_message"=>"Vous n'avez pas access à cette Ressource",
    ],
     collectionOperations:[
        // ****************************************
        "add" => [
            'method' => 'Post',
            "path"=>"/menu2",
            "controller"=>MenuController::class,
        ],

        // ******************************************
        "get"=>[
            'normalization_context' => ['groups' => ['produit:menu:read']]
        ],
        "post"=>[
            'denormalization_context' => ['groups' => ["produit:write:menu"]]
        ]
     ],
     itemOperations:["put","get"=>[
        'normalization_context' => ['groups' => ['produit:menu:lecture']]

     ],"delete"]
)]
#[ORM\Entity(repositoryClass: MenuRepository::class)]
class Menu extends Produit
{
  
  
    #[Groups(["produit:write:menu",'produit:menu:read','produit:menu:lecture'])]
    protected $nomProduit;

    #[Groups(["produit:write:menu",'produit:menu:read','produit:menu:lecture'])]
    protected $plainimage;

    // // #[Groups(["produit:write:menu"])]
    // protected $prix;

    #[Groups(["produit:write:menu",'produit:menu:read','produit:catalogue:read','produit:menu:lecture'])]
    #[ORM\OneToMany(mappedBy: 'menu', targetEntity: MenuBurger::class,cascade:["persist"])]
    private $menuBurgers;

    #[Groups(["produit:write:menu",'produit:menu:read','produit:catalogue:read','produit:menu:lecture'])]
    #[ORM\OneToMany(mappedBy: 'menus', targetEntity: MenuPortionFrite::class,cascade:["persist"])]
    private $menuPortionFrites;

    #[Groups(["produit:write:menu",'produit:menu:read','produit:catalogue:read','produit:menu:lecture'])]
    #[ORM\OneToMany(mappedBy: 'menu', targetEntity: MenuTailleBoisson::class,cascade:["persist"])]
    private $menuTailleBoissons;

    public function __construct()
    {
       
        
        $this->menuBurgers = new ArrayCollection();
        $this->menuPortionFrites = new ArrayCollection();
        $this->menuTailleBoissons = new ArrayCollection();
        
    }

 
    public function prixTotalFrite($menu){
        $prix=0;
        $portionDeFrite=$menu->getMenuPortionFrites();
        foreach ($portionDeFrite as $frite) {
            $quantiteFrite=$frite->getQuantite();
            $prixFrite=$frite->getFrite()->getPrix();
            $prix+=$prixFrite* $quantiteFrite;
        }
        return $prix;
    }

    public function prixTotalBurger($menu){
        $prix=0;
        $menuBurger=$menu->getMenuBurgers();
        foreach ($menuBurger as $burger) {
            $prixBurger=$burger->getBurger()->getPrix();
            $quantiteDansLeMenu=$burger->getQuantite();
            $prix+=$prixBurger*$quantiteDansLeMenu;
        }
        return $prix;
    }



    public function prixTotalBoisson($menu){
        $prix=0;
        $boissons=$menu->getMenuTailleBoissons();
        foreach ( $boissons as  $tailleBoisson) {
            //Quantité
          $nombreDeBoisson=$tailleBoisson-> getQuantite();
          $tailleBoisson=$tailleBoisson->getTailleBoisson();
           //la boisson concerner
         $typeDeBoissons= $tailleBoisson->getBoissons();
          foreach ($typeDeBoissons as $typeBoisson) {
            //Prix de la Boisson concernée 
            $prixDuBoisson=$typeBoisson->getPrix();
            $prix+=$prixDuBoisson*$nombreDeBoisson;
          }
           
        }
       
        return $prix;
    }


    public function prixMenu($menuCommande){
        $totalBurger=$menuCommande->prixTotalBurger($menuCommande);
        $totalFrite=$menuCommande->prixTotalFrite($menuCommande);
        $totalBoisson=$menuCommande->prixTotalBoisson($menuCommande);
         $reduction=($totalBurger+$totalBoisson+$totalFrite)*0.5;
        return  $reduction ;
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
            $menuBurger->setMenu($this);
        }

        return $this;
    }

    public function removeMenuBurger(MenuBurger $menuBurger): self
    {
        if ($this->menuBurgers->removeElement($menuBurger)) {
            // set the owning side to null (unless already changed)
            if ($menuBurger->getMenu() === $this) {
                $menuBurger->setMenu(null);
            }
        }

        return $this;
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
            $menuPortionFrite->setMenus($this);
        }

        return $this;
    }

    public function removeMenuPortionFrite(MenuPortionFrite $menuPortionFrite): self
    {
        if ($this->menuPortionFrites->removeElement($menuPortionFrite)) {
            // set the owning side to null (unless already changed)
            if ($menuPortionFrite->getMenus() === $this) {
                $menuPortionFrite->setMenus(null);
            }
        }

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
            $menuTailleBoisson->setMenu($this);
        }

        return $this;
    }

    public function removeMenuTailleBoisson(MenuTailleBoisson $menuTailleBoisson): self
    {
        if ($this->menuTailleBoissons->removeElement($menuTailleBoisson)) {
            // set the owning side to null (unless already changed)
            if ($menuTailleBoisson->getMenu() === $this) {
                $menuTailleBoisson->setMenu(null);
            }
        }

        return $this;
    }
    
}
                  
    

    

    




