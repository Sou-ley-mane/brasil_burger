<?php
namespace App\DataPersister;
use DateTime;
use App\Entity\Menu;
use App\Entity\Burger;
use App\Entity\Frites;
use App\Entity\Boisson;
use App\Entity\Produit;
use App\Entity\Commande;
use App\ServiceMailler\MaillerService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use ApiPlatform\Core\DataPersister\DataPersisterInterface;
use App\Entity\TailleBoisson;
use App\Repository\BoissonRepository;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;


class CommandeDataPersister   implements DataPersisterInterface 
{

// //Declaration des variables 

private ?TokenInterface $token;
private EntityManagerInterface  $em ;
private MaillerService $email;


public function __construct(TokenStorageInterface $token,EntityManagerInterface $em,MaillerService $email,
  BoissonRepository $boissonRepository)
{
    $this->token = $token->getToken();
    $this->em = $em; 
    $this->email=$email;
    $this->boissonRepository=$boissonRepository;
    
      
} 

// // Verification de la prise en  charge des données
public function supports($data): bool
{ 
return $data instanceof Commande;
}

public function persist($data)
{ 
  
  $count=0;
  $nombreLigneCommande=count($data->getLigneCommandes());
foreach ($data->getLigneCommandes() as $ligneCmd) {

// if ($ligneCmd->getProduit() instanceof Menu) {
// dd("okkkk");
// }


//Test sur la variété et la taille de boisson
  if ( $ligneCmd->getProduit() instanceof Boisson) {
    // dd($ligneCmd->getProduit()->getStock());
    $tab=[];
       $quantite=$ligneCmd->getQuantite();
      // dd($this->boissonRepository->findAll());
      foreach ($this->boissonRepository->findAll() as $boissonT) {
      $tab[]=$boissonT->getNomProduit();
      }

        foreach ($tab as $nomB) {
          if ($ligneCmd->getProduit()->getNomProduit()==$nomB) {
            foreach ($ligneCmd->getProduit()->getTailleBoissons() as $model) {
              $model->getLibelle();
              if ($model->getLibelle()=="canette" && $quantite> $ligneCmd->getProduit()->getStock()) {
                  $result="la quantité demandée de cannette ".$nomB." n'est pas disponible";
                  return new JsonResponse($result ,400);
               }elseif ($model->getLibelle()=="grand_mode" && $quantite > $ligneCmd->getProduit()->getStock()) {
                  $result="la quantite demandee de grand model fanta n'est pas disponible";
                  return new JsonResponse($result ,400);
               }
            }      
          }
          
        }
        $ligneCmd->getProduit()->setStock($ligneCmd->getProduit()->getStock()-$quantite);  
  }

  if ($ligneCmd->getQuantite()<=0) {
    $result="Donner une quantite";
    return new JsonResponse($result ,400);
  }
  // dd($ligneCmd->getProduit());
  //  if (!$ligneCmd->getProduit() instanceof Burger) {
  //     $count++;
  //   }
    // $ligneCmd->getProduit()->getPrix()*$ligneCmd->getQuantite();
   $ligneCmd->setPrix($ligneCmd->getProduit()->getPrix()*$ligneCmd->getQuantite());
}
// if ($count==$nombreLigneCommande) {
//   $result="Burger obligatoire";
//   return new JsonResponse($result ,400);
// }

                                              
$data-> setNumCmd("CMD00".date("his"));
$data->setClient($this->token->getUser()); 
$this->em->persist($data);
$this->em->flush();
// $this->email->sendEmail($this->token->getUser()->getEmail(),$this->token->getUser()->getPrenom()  );

}
// if ($rang==$nombreLigneCommande) {
//   $result="Burger obligatoire";
//   return new JsonResponse($result ,400);
// }


// //Suppression des données
public function remove($data)                                       
{

 dd( $data->getLivraison());

$this->em  ->flush();
}


    
}

