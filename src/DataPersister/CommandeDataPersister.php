<?php
namespace App\DataPersister;
use App\Entity\Menu;
use App\Entity\Burger;
use App\Entity\Produit;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use ApiPlatform\Core\DataPersister\DataPersisterInterface;
use App\Entity\Boisson;
use App\Entity\Commande;
use App\Entity\Frites;
use App\ServiceMailler\MaillerService;
use DateTime;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;


class CommandeDataPersister   implements DataPersisterInterface 
{

// //Declaration des variables 

private ?TokenInterface $token;
private EntityManagerInterface  $em ;
private MaillerService $email;


public function __construct(TokenStorageInterface $token,EntityManagerInterface $em,MaillerService $email)
{
    $this->token = $token->getToken();
    $this->em = $em; 
    $this->email=$email;
      
} 
// // Verification de la prise en  charge des données
public function supports($data): bool
{ 
return $data instanceof Commande;
}
// **************************

public function persist($data)
{ 
  // dd();
$ligneCommande=$data->getLigneCommandes();
// dd($ligneCommande);
foreach ($ligneCommande as $produit) {
  $produit->getQuantite();
  $produit->getProduit()->getPrix()*$produit->getQuantite();
  // dd( $produit->getProduit()->getPrix()*$produit->getQuantite());
  $produit->setPrix($produit->getProduit()->getPrix()*$produit->getQuantite());
}

$data-> setNumCmd("CMD00".date("his"));
$data->setClient($this->token->getUser()); 
$this->em->persist($data);
$this->em->flush();
// $this->email->sendEmail($this->token->getUser()->getEmail(),$this->token->getUser()->getPrenom()  );

}


// //Suppression des données
public function remove($data)                                       
{
  if ($data instanceof Menu) { 
    $data->setEtatProduit("false");
  }
  else if ($data instanceof Burger || $data instanceof Boisson || $data instanceof Frites) {
    // $lesMenus=$data->getMenus();      
    // dd($lesMenus);
    // $result= count($lesMenus) ;
  // if ($result==0) {
  //   $data->setEtatProduit("false");
  //     $this->em->persist($data);
  // }else {
  //   echo('Ce produit se trouve dans menu');
  //   echo("   .  ");
  //   echo('Pour pouvoir le supprimer merci de le retiré dans le menu');
  //   dd();
  // }
}
$this->em  ->flush();
}


    
}

