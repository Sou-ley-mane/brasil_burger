<?php
namespace App\DataPersister;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
// use Symfony\Component\VarDumper\Dumper\DataDumperInterface;
use ApiPlatform\Core\DataPersister\DataPersisterInterface;
use App\Entity\Livreur;

// use App\service\SendMail;
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
* @p                                            aram User $data
*/
public function persist($data)
{
   
$hashedPassword = $this->passwordHasher->hashPassword($data,'passer');
$data->setPassword($hashedPassword);

if ($data instanceof Livreur) {
   $data->setMatricule("MAT-".date("dmYHis"));
}   

$this->entityManager->persist($data);
$this->entityManager->flush();
                                                                            
;

}

//Suppression des données
public function remove($data)
{
$this->entityManager->remove($data);
$this->entityManager->flush();
}

}
