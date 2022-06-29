<?php

namespace App\EventSubscriber;


use App\Entity\Burger;
use App\Entity\Produit;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class ProduitSubscriber implements EventSubscriberInterface
{
private TokenInterface $token;
    public function __construct(TokenStorageInterface $tokenStorage)
    {
        $this->token=$tokenStorage->getToken();
    }
    // public function onPrePersist($event): void
    // {
    //     // ...
    // }

    public static function getSubscribedEvents(): array
    {
       
        return [
            'Events' => 'prePersist',
        ];
    }


    public function getUtilisateur(){
       

        // dd("ok");
        if (null===$token=$this->token) {
            return null;
        }
       
    if (!is_object($user = $token->getUser())) {
        // e.g. anonymous authentication
      
        return null;
        }
        // dd($user);
        return $user;
    }
    
public function prePersist(LifecycleEventArgs $args)
{
    if ($args->getObject() instanceof Burger) {
     $args->getObject()->setGestionnaire($this->getUtilisateur());
}
}


    
}
