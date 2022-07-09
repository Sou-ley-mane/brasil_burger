<?php

namespace App\Controller;

use App\Entity\Menu;
use App\Entity\Menu2;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MenuController extends AbstractController
{
   
    public function __invoke(Request $request, SerializerInterface $serializer,EntityManagerInterface $entityManager): JsonResponse{
    $prix=0;
    $menu=$request->getContent();
    // $data=json_decode($menu);
    // dd($data->menuBurgers[0]->burger);
    $menu=$serializer->deserialize($request->getContent(),Menu::class,'json');
    $prixFrite=$menu-> prixTotalFrite($menu);
    $prixBoisson=$menu->prixTotalBoisson($menu);
    $menu->getMenuBurgers();
    foreach ($menu->getMenuBurgers() as $menuBurger) {
        $menuBurger->getBurger()->getPrix();
    }
    $prix+=$prixBoisson+$prixFrite+$menuBurger->getBurger()->getPrix();
    $menu->setPrix($prix);
    $entityManager->persist($menu);
    $entityManager->flush();
    // $menu=$serializer->serialize($menu);
    return new JsonResponse($menu);

    }

}
