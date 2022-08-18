<?php
namespace App\DataPersister;
use App\Entity\User;
use App\Entity\Livreur;
// use Symfony\Component\VarDumper\Dumper\DataDumperInterface;
use App\Entity\Gestionnaire;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
// use App\service\SendMail;
use ApiPlatform\Core\DataPersister\DataPersisterInterface;
use App\Entity\Client;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class DataPersister  implements DataPersisterInterface 
{
 
private UserPasswordHasherInterface $passwordHasher;
private EntityManagerInterface $entityManager;
private ?TokenInterface $token;


//C onstructeur
    public function __construct(UserPasswordHasherInterface $passwordHasher,EntityManagerInterface $entityManager,TokenStorageInterface $tokenStorage)
{
    // dd("azerty");
$this->passwordHasher= $passwordHasher;
$this->entityManager = $entityManager;
$this->token = $tokenStorage->getToken();

// dd($this->email);
}                            

// Verification de la prise en  charge des données
public function supports($data): bool
{
return $data instanceof User;
}


//Poour mettre mettre a jour les données stockées
/**
* @param User $data
*/
public function persist($data)
{
   
$hashedPassword = $this->passwordHasher->hashPassword($data,'passer');
$data->setPassword($hashedPassword);


if ($data instanceof Livreur) {
   $data->setMatricule("Moto-".date("His")."-DK");
   $data->setRoles(["ROLE_LIVREUR"]);
   $data->setEtat("disponible");
//    $data->setGestionnaire($this->token ->getUser());
}elseif ($data instanceof Gestionnaire) {
 $data->setEtat("actif");
 $data->setRoles(["ROLE_GESTIONNAIRE"]);
} elseif ($data instanceof Client) {
    $data->setEtat("true");
    $data->setRoles(["ROLE_CLIENT"]);
    
}

$this->entityManager->persist($data);
$this->entityManager->flush();
                                                                            
;

}

//Suppression des données
public function remove($data)
{
    if ($data instanceof Gestionnaire) {
         $etatGestionnaire=$data->getEtat();
        if ($etatGestionnaire=="non_actif") {
            dd("Ce gestionnaire est déja supprimer");
        }else {
            $data->setEtat("non_actif");
            $this->entityManager->persist($data);
            $this->entityManager->flush();
        }
    }elseif ($data instanceof Client) {
        $etatClient=$data->getEtat();
        if ( $etatClient=="false") {
            dd("Ce Client est déja supprimer");
        }else {
            $data->setEtat("false");
            $this->entityManager->persist($data);
            $this->entityManager->flush();
        }
    }elseif ($data instanceof Livreur) {
        dd("La suppression n'est pas encore parametrée");
        $this->entityManager->persist($data);
        $this->entityManager->flush();
    }
 

}

}
