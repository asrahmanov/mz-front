<?php

namespace App\Controller;

use App\Form\ReviewFilterType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ReviewRepository;

class ReviewController extends AbstractController
{
    private ReviewRepository $repository;

    public function __construct(ReviewRepository $repository)
    {
        $this->repository = $repository;
    }

    #[Route('/reviews', name: 'reviews')]
    public function index(Request $request): Response
    {
        $filterForm = $this->createForm(ReviewFilterType::class);
        $filter = [];

        $filterForm->handleRequest($request);

        if ($filterForm->isSubmitted() && $filterForm->isValid()) {
            $filter = $filterForm->getData();
        }

        return $this->render('review/index.html.twig', [
            'reviews' => $this->repository->filter($filter),
            'reviewFilterForm' => $filterForm->createView()
        ]);
    }
}
