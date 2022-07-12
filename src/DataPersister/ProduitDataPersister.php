<?php
namespace App\DataPersister;
use App\Entity\Menu;
use App\Entity\Burger;
use App\Entity\Frites;
use App\Entity\Boisson;
use App\Entity\Produit;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use ApiPlatform\Core\DataPersister\DataPersisterInterface;
use PhpParser\Node\Stmt\ElseIf_;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;


class ProduitDataPersister  implements DataPersisterInterface 
{

//Declaration des variables 

private ?TokenInterface $token;
private EntityManagerInterface  $em ;



public function __construct(TokenStorageInterface $token,EntityManagerInterface $em)
{
    $this->token = $token->getToken();
    $this->em = $em;   
} 
// // Verification de la prise en  charge des données
public function supports($data): bool
{ 
return $data instanceof Produit;
}
// // **************************

public function persist($data)
{
//  dd($data-> getImage());

// Calculer l;e prix du menu
if ($data instanceof Menu) {
    // $data->prixTotalBoisson($data);
    // $data->prixTotalFrite($data);
    // $data->prixTotalBurger($data);
    // $data->prixMenu($data);
  $data->setPrix( $data->prixMenu($data));
  
}

// $image=$data->getbImage();
// $image->setImage(file_get_contents($image));
// dd($image);
$data->setGestionnaire($this->token->getUser()); 
$this->em->persist($data);
$this->em->flush();
}

 //Suppression des données
public function remove($data)
{
  if ($data instanceof Menu) {
    $data->setEtatProduit("false");
    $this->em->persist($data);
    $this->em  ->flush();
  }
  // || $data instanceof Boisson || $data instanceof Frites
  else if ($data instanceof Burger ) {
   if ($data->getMenuBurgers()!=null) {
     dd("impossible de supprimer ce burgers");
    $result="impossible de supprimer ce burgers";
    return new JsonResponse($result ,400);
  
   }
    $data->setEtatProduit("false");
    $this->em->persist($data);
    $this->em  ->flush();
}elseif ($data instanceof Frites) {
  if ($data->getMenuPortionFrites()!=null) {
    dd("cette portion de frites se trouve dans un menu");
  }
  $data->setEtatProduit("false");
  $this->em->persist($data);
  $this->em  ->flush();
 
}  

}


 }