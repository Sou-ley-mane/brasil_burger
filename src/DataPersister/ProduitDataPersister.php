<?php
namespace App\DataPersister;
use App\Entity\Menu;
use App\Entity\Burger;
use App\Entity\Produit;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use ApiPlatform\Core\DataPersister\DataPersisterInterface;
use App\Entity\Boisson;
use App\Entity\Frites;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;


class ProduitDataPersister  implements DataPersisterInterface 
{

// //Declaration des variables 

private ?TokenInterface $token;
private EntityManagerInterface  $em ;
private int $a;


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
// **************************

public function persist($data)
{
 
//Calculer le prix du menu
if ($data instanceof Menu) {
  
  $burgers=$data->getBurgers();
  $boisson=$data->getBoissons();
  $portionFrite=$data->getPortionDeFrites();

  if (count($burgers)==0) {
    dd("burger Obligatoire");  
  
  }elseif(count($boisson)==0 && count($portionFrite)==0){

    dd("Complement Obligatoire");  

  }
    $prixDuMenu=$data->prixMenu($data);
    $data->setPrix($prixDuMenu);
}

$data->setGestionnaire($this->token->getUser()); 
$this->em->persist($data);
$this->em->flush();
}


// //Suppression des données
public function remove($data)
{
  if ($data instanceof Menu) {
  
   
    $data->setEtatProduit("false");
  }
  else if ($data instanceof Burger || $data instanceof Boisson || $data instanceof Frites) {
    $lesMenus=$data->getMenus();
    // dd($lesMenus);
    $result= count($lesMenus) ;
  if ($result==0) {
    $data->setEtatProduit("false");
      $this->em->persist($data);
  }else {
    echo('Ce produit se trouve dans menu');
    echo("   .  ");
    echo('Pour pouvoir le supprimer merci de le retiré dans le menu');
    dd();
  }
}
$this->em  ->flush();
}


    
}
