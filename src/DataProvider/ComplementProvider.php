<?php

namespace App\DataProvider;


use ApiPlatform\Core\DataProvider\ContextAwareCollectionDataProviderInterface;
use App\Entity\Complement;
use App\Repository\BoissonRepository;
use App\Repository\FritesRepository;

class ComplementProvider implements ContextAwareCollectionDataProviderInterface{

public function __construct(BoissonRepository $boissonRepository,FritesRepository $fritesRepository)
{
  $this->fritesRepository=$fritesRepository;
  $this->boissonRepository=$boissonRepository;
    
}
public function supports(string $resourceClass, string $operationName = null, array $context = []): bool
{
    return $resourceClass=Complement::class;
}

public function getCollection(string $resourceClass, string $operationName = null, array $context = [])
{
    
 return   $context[]=$this->boissonRepository->findAll();
}
    
}

