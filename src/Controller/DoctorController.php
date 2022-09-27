<?php

namespace App\Controller;

use App\Entity\Doctor;
use App\Entity\PriceCategory;
use App\Entity\Specialty;
use App\Form\DoctorSearchType;
use App\Repository\ArticleRepository;
use App\Repository\ArticleTagRepository;
use App\Repository\ClinicRepository;
use App\Repository\DoctorRepository;
use App\Repository\PriceCategoryRepository;
use App\Repository\SpecialtyRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class DoctorController extends AbstractController
{
    #[Route('/doctors', name: 'doctors')]
    public function index(
        DoctorRepository $doctorRepository,
        Request $request
    ): Response
    {
        $doctorSearchForm = $this->createForm(DoctorSearchType::class);
        $doctorSearchForm->handleRequest($request);

        $filter = [];

        if  ($doctorSearchForm->isSubmitted() && $doctorSearchForm->isValid()) {
            $filter = $doctorSearchForm->getData();
        }

        $doctors = $doctorRepository->search($filter);

        return $this->render('doctor/index.html.twig', [
            'doctorsSearchForm' => $doctorSearchForm->createView(),
            'doctors' => $doctors,
            'leadingSpecialistsCount' => $doctorRepository->count(['leadingSpecialist' => true])
        ]);
    }

    /**
     * @Route("/doctor/{slug}", name="doctor.show")
     * @param Doctor $doctor
     * @param PriceCategoryRepository $priceCategoryRepository
     * @return Response
     */
    public function show(
        Doctor $doctor,
        PriceCategoryRepository $priceCategoryRepository,
        ArticleTagRepository $articleTagRepository,
        ArticleRepository $articleRepository,
        DoctorRepository $doctorRepository,
    )
    {
        if (! $doctor->getIsEnabled()) {
            throw new NotFoundHttpException();
        }
        return $this->render('doctor/show.html.twig', [
            'doctors' => $doctorRepository->findAll(),
            'doctor' => $doctor,
            'price' => $priceCategoryRepository->getForPrice(['doctorId' => $doctor->getId()]),
            'articleTags' => $articleTagRepository->search(),
            'popularArticles' => $articleRepository->findBy(['isPopular' => true])
        ]);
    }

    #[Route('/doctors/{slug}', name: 'doctors_by_specialty')]
    public function specialty(Specialty $specialty, DoctorRepository $doctorRepository)
    {
        if (!$specialty) {
            throw $this->createNotFoundException();
        }
        return $this->render('specialty/show.html.twig', [
            'specialty' => $specialty,
        ]);
    }
}
