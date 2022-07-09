<?php
namespace App\ServiceMailler;

use App\Repository\BurgerRepository;

class ServiceGestionStock 
{

    public function __construct(BurgerRepository $burgerRepo)
    {
        $this->burgerRepo=$burgerRepo;
    }


    public function stockBurger(){
        $this->burgerRepo->findByEtatProduit("");
    }
   
 
}
