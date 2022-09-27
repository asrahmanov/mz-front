<?php

namespace App\Controller;

use App\Repository\ArticleRepository;
use App\Repository\ArticleTagRepository;
use App\Repository\BranchRepository;
use App\Repository\CertRepository;
use App\Repository\ClinicRatingRepository;
use App\Repository\ClinicRepository;
use App\Repository\DoctorRepository;
use App\Repository\ReviewRepository;
use App\Repository\SpecialtyRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="main")
     * @return Response
     */
    public function index(
        DoctorRepository $doctorRepository,
        SpecialtyRepository $specialtyRepository,
        ClinicRepository $clinicRepository,
        BranchRepository $branchRepository,
        ReviewRepository $reviewRepository,
        ArticleRepository $articleRepository,
        ArticleTagRepository $articleTagRepository,
        ClinicRatingRepository $clinicRatingRepository,
        CertRepository $certRepository,

    ): Response
    {
        return $this->render('main/index.html.twig', [
            'doctors' => $doctorRepository->findAll(),
            'specialities' => $specialtyRepository->getForDoctorsFilter(),
            'clinics' => $clinicRepository->findBy([],['isMain' => 'desc']),
            'branches' => $branchRepository->getForMainPage(),
            'reviews' => $reviewRepository->getForMainPage(),
            'articles' => $articleRepository->search([], 1, 2),
            'popularArticles' => $articleRepository->getPopular(null, 4),
            'articleTags' => $articleTagRepository->search(),
            'ratings' => $clinicRatingRepository->findAll(),
            'certs' => $certRepository->getForMainPage(),
        ]);
    }
}
