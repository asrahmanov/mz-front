<?php

namespace App\Controller;

use App\Entity\Specialty;
use App\Repository\SpecialtyRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SpecialtyController extends AbstractController
{
    #[Route('/specializations', name: 'specialty.list')]
    public function index(): Response
    {
        $specialities = $this->getDoctrine()->getRepository(Specialty::class)->findAll();
        return $this->render('specialty/index.html.twig', [
            'specialities' => $specialities,
        ]);
    }

    #[Route('/specialization/{slug}', name: 'specialty.show')]
    public function show(Specialty $specialty): Response
    {
        return $this->render('specialty/show.html.twig', [
            'specialty' => $specialty,
        ]);
    }
}
