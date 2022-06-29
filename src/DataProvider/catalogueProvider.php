<?php

namespace App\DataProvider;


use ApiPlatform\Core\DataProvider\ContextAwareCollectionDataProviderInterface;
use App\Entity\Catalogue;
use App\Repository\BurgerRepository;
use App\Repository\MenuRepository;

class catalogueProvider implements ContextAwareCollectionDataProviderInterface{

public function __construct(BurgerRepository $burgerRepo,MenuRepository $menuRepository)
{
    // dd("providerAZER");
    $this->burgerRepo=$burgerRepo;
    $this->menuRepository=$menuRepository;
    
}
public function supports(string $resourceClass, string $operationName = null, array $context = []): bool
{
    return $resourceClass=Catalogue::class;
}

public function getCollection(string $resourceClass, string $operationName = null, array $context = [])
{
    
 return   $context[]=$this->menuRepository->findAll();
}
    
}

