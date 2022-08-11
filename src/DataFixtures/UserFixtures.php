<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
   
    private $passwordhas;
    
    public function __construct(UserPasswordHasherInterface $passwordhas)
    {
        $this->passwordhas=$passwordhas;
    }


    public function load(ObjectManager $manager): void
    {
        $user = new User();
        
        $user->setEmail("diallo@gmail.com");
        $user->setNom("diallo");
        // $user->setRole(" CLIENT");
        $user->setPrenom("Souleymane");
        // $user->setPassword("john");
        $user->setRoles(["ROLE_CLIENT"]);
        $user->setEtat("actif");
        // $user->setPassword( $passHah->hashPassword($etudiant,$mdp))
        // $user->setPassword($this->passwordhas->hashPassword(($user, "wick"));
        $user->setPassword($this->passwordhas->hashPassword($user, "mdp"));
        $manager->persist($user);
        $user2 = new User();
        $user2->setEmail("samb@gmail.com");
        $user->setEtat("actif");
        // $user2->setRole("GESTIONNAIRE");
        
        $user2->setNom("samb");
        $user2->setPrenom("Ahmed");
        // $user2->setPassword("jack");
        $user->setRoles(["ROLE_GESTIONNAIRE"]);

        $user2->setPassword($this->passwordhas->hashPassword($user2,"mdp"));
        // $user2->setPassword($this->passwordEncoder->encodePassword($user2, "dalton"));
        $manager->persist($user2);
        $manager->flush();

        // $manager->flush();
    }
}
