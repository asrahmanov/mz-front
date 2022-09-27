<?php

namespace App\Controller;

use App\Entity\Clinic;
use App\Repository\ClinicRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ContactsPageController extends AbstractController
{
    /**
     * @Route("/contacts/{slug?}", name="contacts")
     * @return Response
     */
    public function show(ClinicRepository $clinicRepository, Clinic $clinic = null)
    {
        if (! $clinic) {
            $clinic = $clinicRepository->findOneBy([], ['isMain' => 'desc']);
        }

        return $this->render('contacts/show.html.twig', [
            'clinic' => $clinic,
            'clinics' => $clinicRepository->findBy([], ['isMain' => 'desc']),
        ]);
    }

    public function footerMap(ClinicRepository $clinicRepository)
    {
        return $this->render('_footer_map.html.twig', [
            'clinics' => $clinicRepository->findBy([], ['isMain' => 'desc'])
        ]);
    }
}
