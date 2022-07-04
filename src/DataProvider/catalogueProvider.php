<?php

namespace App\DataProvider;


use ApiPlatform\Core\DataProvider\ContextAwareCollectionDataProviderInterface;
use App\Entity\Catalogue;
use App\Repository\BurgerRepository;
use App\Repository\MenuRepository;

use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;

class catalogueProvider implements ContextAwareCollectionDataProviderInterface,RestrictedDataProviderInterface{

public function __construct(BurgerRepository $burgerRepo,MenuRepository $menuRepository)
{
    // dd("providerAZER");
    $this->burgerRepo=$burgerRepo;
    $this->menuRepository=$menuRepository;
    
}
public function supports(string $resourceClass, string $operationName = null, array $context = []): bool
{
    
    return $resourceClass===Catalogue::class;
}

public function getCollection(string $resourceClass, string $operationName = null, array $context = [])
{
    // dd($this->menuRepository->findAll());
 return   $context=[
    $this->menuRepository->findAll(),
    $this->burgerRepo->findAll()
];
}

    
}

