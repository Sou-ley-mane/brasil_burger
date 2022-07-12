<?php

namespace App\Entity;


use ApiPlatform\Core\Annotation\ApiResource;



#[ApiResource(
    collectionOperations:[
    "catalogue"=> [
        'method'=> 'GET',
        'path'=>"/complement",
        'normalization_context' => ['groups' => ['produit:complement:read']],

        ] ,
    ],
    itemOperations:[])]
class Complement 
{
 
}
