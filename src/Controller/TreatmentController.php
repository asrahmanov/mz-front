<?php

namespace App\Controller;

use App\Entity\Treatment;
use App\Repository\BannerRepository;
use App\Repository\ClinicRepository;
use App\Repository\DoctorRepository;
use App\Repository\PriceCategoryRepository;
use App\Repository\PromoRepository;
use App\Repository\ReviewRepository;
use App\Repository\SpecialtyRepository;
use App\Repository\TreatmentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TreatmentController extends AbstractController
{
    #[Route('/treatments', name: 'treatments')]
    public function index(
        TreatmentRepository $treatmentRepository,
        ClinicRepository $clinicRepository,
        ReviewRepository $reviewRepository,
        DoctorRepository $doctorRepository,
        SpecialtyRepository $specialtyRepository
    ): Response
    {
        return $this->render('treatment/index.html.twig', [
            'treatments' => $treatmentRepository->findAll(),
            'totalClinics' => $clinicRepository->count([]),
            'reviews' => $reviewRepository->getForMainPage(),
            'doctors' => $doctorRepository->findAll(),
            'specialities' => $specialtyRepository->getForDoctorsFilter(),
        ]);
    }

    /**
     * @Route("/treatment/{slug}", name="treatment.show")
     */
    public function show(
        Treatment $treatment,
        PriceCategoryRepository $priceCategoryRepository,
        BannerRepository $bannerRepository
    ): Response
    {
        $price = null;

        if ($priceItems = $treatment->getPriceItems()) {
            $priceItemIds = $priceItems->map(function($item) {
                return $item->getId();
            })->toArray();

            $price = $priceCategoryRepository->getForPrice([
                'items' => $priceItemIds,
            ]);
        }

        $banners = $bannerRepository->findByLocationList([
            'treatment_page_1',
            'treatment_page_2',
            'treatment_page_3',
        ]);


        return $this->render('treatment/show.html.twig', [
            'treatment' => $treatment,
            'price' => $price,
            'banners' => $banners
        ]);
    }
}
