<?php

namespace App\Controller;

use App\Entity\Doctor;
use App\Entity\PriceCategory;
use App\Entity\PriceTag;
use App\Repository\PriceTagRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PriceItemController extends AbstractController
{
    #[Route('/prices', name: 'prices')]
    public function index(Request $request): Response
    {
        $filter = $request->get('filter', []);

        $price = $this->getDoctrine()->getRepository(PriceCategory::class)->getForPrice($filter);
        $doctors = $this->getDoctrine()->getRepository(Doctor::class)->getForPrice($filter);
        $tags = $this->getDoctrine()->getRepository(PriceTag::class)->getForPrice($filter);

        return $this->render('price/index.html.twig', [
            'price' => $price,
            'tags' => $tags,
        ]);
    }


}
