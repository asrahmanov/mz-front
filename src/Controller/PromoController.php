<?php

namespace App\Controller;

use App\Entity\Promo;
use App\Repository\PromoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PromoController extends AbstractController
{
    #[Route('/promos', name: 'promos')]
    public function index(PromoRepository $promoRepository): Response
    {
        $promos = $promoRepository->findAll();
        return $this->render('promo/index.html.twig', [
            'promos' => $promos,
        ]);
    }

    /**
     * @Route("/promo/{slug}", name="promo.show")
     * @param Promo $promo
     */
    public function show(Promo $promo)
    {
        return $this->render('promo/show.html.twig',[
            'promo' => $promo,
        ]);
    }
}
