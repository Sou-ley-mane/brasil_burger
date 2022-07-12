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
  
  // Recupération du tableau de commande
$ligneCommande=$data->getLigneCommandes();

foreach ($ligneCommande as $ligneCmd) {
  //la quante dans une ligne de c ommande
  $ligneCmd->getQuantite();
  $ligneCmd->getProduit()->getPrix()*$ligneCmd->getQuantite();
  //prix d'une ligne de commande
  $ligneCmd->setPrix($ligneCmd->getProduit()->getPrix()*$ligneCmd->getQuantite());
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

 dd( $data->getLivraison());

$this->em  ->flush();
}


    
}

