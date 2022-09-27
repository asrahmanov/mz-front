<?php

namespace App\Controller;

use App\Repository\MenuRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MenuController extends AbstractController
{
    /**
     * @Route("/menu/main", name="main-menu")
     * @param MenuRepository $menuRepository
     * @return Response
     */
    public function main(MenuRepository $menuRepository, RequestStack $requestStack): Response
    {
        $menu = $menuRepository->findOneBy(['slug' => 'main-menu']);
        $baseRequest = $requestStack->getMasterRequest();
        return $this->render('_main-menu/_menu.html.twig', [
            'menu' => $menu,
            'baseRequest' => $baseRequest
        ]);
    }

    public function bottom(MenuRepository $menuRepository, RequestStack $requestStack): Response
    {
        $menu = $menuRepository->findOneBy(['slug' => 'bottom-menu']);
        $baseRequest = $requestStack->getMasterRequest();
        return $this->render('_bottom_menu/_menu.html.twig', [
            'menu' => $menu->getData(),
            'baseRequest' => $baseRequest
        ]);
    }
}
