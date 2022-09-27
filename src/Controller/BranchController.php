<?php

namespace App\Controller;

use App\Entity\Branch;
use App\Repository\ArticleRepository;
use App\Repository\BranchRepository;
use App\Repository\ClinicRepository;
use App\Repository\DiseaseRepository;
use App\Repository\PriceCategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BranchController extends AbstractController
{
    /**
     * @Route("/branches", name="branches")
     * @return Response
     */
    public function index(
        BranchRepository $branchRepository,
        DiseaseRepository $diseaseRepository,
        ClinicRepository $clinicRepository
    )
    {
        $branches = $branchRepository->findAll();
        $diseases = $diseaseRepository->findAll();
        $clinics = $clinicRepository->findAll();

        return $this->render('branch/index.html.twig', [
            'branches' => $branches,
            'diseases' => $diseases,
            'clinics' => $clinics,
        ]);
    }

    /**
     * @Route ("/branch/{slug}", name="branch.show")
     * @param Branch $branch
     */
    public function show(
        Branch $branch,
        PriceCategoryRepository $priceCategoryRepository,
        ArticleRepository $articleRepository
    )
    {
        $price = null;
        $priceItems = $branch->getPriceItems();
        if (! $priceItems->isEmpty()) {
            $priceItemIds = $priceItems->map(function($item) {
                return $item->getId();
            })->toArray();

            $price = $priceCategoryRepository->getForPrice([
                'items' => $priceItemIds,
            ]);
        }

        return $this->render('branch/show.html.twig', [
            'price' => $price,
            'branch' => $branch,
            'popularArticles' => $articleRepository->getPopular()
        ]);
    }
}
