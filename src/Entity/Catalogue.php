<?php

namespace App\Entity;


use ApiPlatform\Core\Annotation\ApiResource;
use Attribute;

#[ApiResource(
    collectionOperations:[
    "catalogue"=> [

        'method'=> 'GET',
        "path"=>"/catalogue",
        'normalization_context' => ['groups' => ['produit:catalogue:read']],


        ] ,
    ],
    itemOperations:[]
    )]
class Catalogue
{
  

  
}
