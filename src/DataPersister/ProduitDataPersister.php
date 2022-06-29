<?php
namespace App\DataPersister;
use ApiPlatform\Core\DataPersister\DataPersisterInterface;
use App\Entity\Produit;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

class ProduitDataPersister  
{

// //Declaration des variables 
private ?TokenInterface $token;
private EntityManagerInterface  $em ;



public function __construct(TokenStorageInterface $token,EntityManagerInterface  $em)
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



// //Poour mettre mettre a jour les données stockées
// /**
// * @p                                            aram User $data
// */
public function persist($data)
{
    dd($this->token->getUser());
    $data->setGestionnaire($this->token->getUser()); 

$this->em->persist($data);
$this->em->flush();
}

// //Suppression des données
public function remove($data)
{
$this->em->remove($data);
$this->em  ->flush();
}


    
}

