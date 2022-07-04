<?php

namespace App\Entity;


use ApiPlatform\Core\Annotation\ApiResource;



#[ApiResource(
    collectionOperations:[
    "catalogue"=> [
        'method'=> 'GET',
        'path'=>"/complement",
        ] ,
    ],
    itemOperations:[])]
class Complement 
{
 
}
