<?php
namespace App\DataPersister;
use App\Entity\User;
use App\Entity\Livreur;
// use Symfony\Component\VarDumper\Dumper\DataDumperInterface;
use App\Entity\Livraison;
use App\Repository\LivreurRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
// use App\service\SendMail;
use Symfony\Component\HttpFoundation\JsonResponse;
use ApiPlatform\Core\DataPersister\DataPersisterInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class LivraisonDataPersister  implements DataPersisterInterface 
{
 

private EntityManagerInterface $entityManager;
private ?TokenInterface $token;

    public function __construct(EntityManagerInterface $entityManager,LivreurRepository $livreur,TokenStorageInterface $token)
{
$this->entityManager = $entityManager;
$this->livreur = $livreur;
$this->token = $token->getToken();
}                        

// Verification de la prise en  charge des données
public function supports($data): bool
{
return $data instanceof Livraison;
}


//Poour mettre mettre a jour les données stockées
/**
// * @param User $data
*/
public function persist($data){
    $lesCommandes=$data->getCommandes();
    foreach ($lesCommandes as $commande) {

        if ($commande->getEtatCmd()=="cours") {
            $result="la commande numéro  ".$commande->getNumCmd()."  est déja en cours de livraison";
            return new JsonResponse($result ,400);
        }
            $livreursDisponible=$this->livreur->findByEtat("disponible"); 
            if (empty($livreursDisponible[array_rand($livreursDisponible)])) {
                $result="Aucun livreur n'est pas disponible";
                return new JsonResponse($result ,400);
            }               
            $livreurCommande=$livreursDisponible[array_rand($livreursDisponible)];
        // if ($livreurCommande->getEtat()=="indisponible") {
        //     $result="le livreur . .n'est pas disponible";
        //     return new JsonResponse($result ,400);
        //le livreur pour livrer la commande
        $data->setLivreur($livreurCommande);
        $data->setEtatLivraison("false");
        $this->entityManager->persist($data);
        $commande->setEtatCmd("cours");
        //LE gestionnaire qui a gérer la livraison
        $commande->setGestionnaire($this->token ->getUser());
        $this->entityManager->persist($commande);  
        $livreurCommande->setEtat("indisponible");   
        $this-> entityManager->persist($livreurCommande);
        $this->entityManager->flush();
}
}
//Suppression des données
public function remove($data)
{
$this->entityManager->persist($data);
$this->entityManager->flush();
}

}

