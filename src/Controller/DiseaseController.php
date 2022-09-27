<?php

namespace App\Controller;

use App\Entity\Disease;
use App\Entity\DiseaseCategory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DiseaseController extends AbstractController
{
    #[Route('/diseases', name: 'diseases')]
    public function index(): Response
    {
        return $this->render('disease_category/index.html.twig', [
            'categories' => $this->getDoctrine()->getRepository(DiseaseCategory::class)->findAll(),
        ]);
    }

    /**
     * @Route("/disease/{slug}", name="disease.show")
     */
    public function show(Disease $disease, Request $request)
    {
        $diseasesViewed = $request->getSession()->get('diseasesViewed', []);
        if (! in_array($disease->getId(), $diseasesViewed)) {
            $disease->setViewsNum($disease->getViewsNum() + 1);
            $this->getDoctrine()->getManager()->flush();
            $diseasesViewed[] = $disease->getId();
            $request->getSession()->set('diseasesViewed', $diseasesViewed);
        }
        return $this->render('disease/show.html.twig', ['disease' => $disease]);
    }

    #[Route('/disease-category/{slug}', name: 'disease-category')]
    public function category(DiseaseCategory $category)
    {
        return $this->render('disease_category/show.html.twig', [
            'category' => $category,
        ]);
    }
}
