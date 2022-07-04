<?php


namespace App\DataProvider;


use ApiPlatform\Core\DataProvider\ContextAwareCollectionDataProviderInterface;


use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;
use App\Entity\Complement;
use App\Repository\BoissonRepository;
use App\Repository\FritesRepository;

class ComplementProvider implements ContextAwareCollectionDataProviderInterface,RestrictedDataProviderInterface{

public function __construct(FritesRepository $fritesRepository,BoissonRepository $boissonRepository)
{
  $this->fritesRepository=$fritesRepository;
  $this->boissonRepository=$boissonRepository; 
    
}


public function getCollection(string $resourceClass, string $operationName = null, array $context = [])
{
  $context["frites"]=$this->fritesRepository->findAll();
  $context["boissons"]= $this->boissonRepository->findAll();
 return  $context;
    // $this->fritesRepository->findAll(),
 
}
public function supports(string $resourceClass, string $operationName = null, array $context = []): bool
{
    return $resourceClass===Complement::class;
}
}

