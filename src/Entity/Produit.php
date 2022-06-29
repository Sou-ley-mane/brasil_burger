<?php

namespace App\Entity;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\ProduitRepository;
use Doctrine\Common\Collections\Collection;
// use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\Common\Collections\ArrayCollection;
use phpDocumentor\Reflection\Types\Nullable;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\InheritanceType("JOINED")]
#[ORM\DiscriminatorColumn(name:"type",type:"string")]
#[ORM\DiscriminatorMap([
     "burger"=>"Burger",
     "menu"=>"Menu",
     "boisson"=>"Boisson",
     "frite"=>"Frites"
     ])]

#[ORM\Entity(repositoryClass: ProduitRepository::class)]
#[ApiResource]
// #[ApiResource(
//     collectionOperations:[
//     "get"=> [
//         'status' => Response::HTTP_OK,
//         'normalization_context' => ['groups' => ['burger:read:simple']],
//         ] ,
//     "post"=> [
//         // 'status' => Response::HTTP_CREATED,
//         'denormalization_context' => ['groups' => ['burger:write:simple']],
//         ] , 
//     ],
//     itemOperations:["put","get"])]
class Produit
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    protected $id;

    //  #[Groups(['burger:read:simple','burger:write:simple'])]
    #[ORM\Column(type: 'string', length: 255)]
    protected $nomProduit;

 
    // #[Groups(['burger:read:simple','burger:write:simple'])]

    #[ORM\Column(type: 'string', length: 255)]
    protected $image;

    // #[Groups(['burger:read:simple','burger:write:simple'])]

    #[ORM\Column(type: 'integer')]
    protected $prix;

   
    #[ORM\Column(type: 'string', length: 255)]
    protected $etatProduit="true";

    #[ORM\ManyToOne(targetEntity: Gestionnaire::class, inversedBy: 'produits')]
    private $gestionnaire;

  

  
    
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomProduit(): ?string
    {
        return $this->nomProduit;
    }

    public function setNomProduit(string $nomProduit): self
    {
        $this->nomProduit = $nomProduit;

        return $this;
    }


    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getPrix(): ?int
    {
        return $this->prix;
    }

    public function setPrix(int $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    public function getEtatProduit(): ?string
    {
        return $this->etatProduit;
    }

    public function setEtatProduit(string $etatProduit): self
    {
        $this->etatProduit = $etatProduit;

        return $this;
    }

    public function getGestionnaire(): ?Gestionnaire
    {
        return $this->gestionnaire;
    }

    public function setGestionnaire(?Gestionnaire $gestionnaire): self
    {
        $this->gestionnaire = $gestionnaire;

        return $this;
    }

    
   
 
}
