<?php


namespace App\Controller;


use App\Entity\PriceCategory;
use App\Entity\Service;
use App\Repository\ArticleRepository;
use App\Repository\ClinicRatingRepository;
use App\Repository\ClinicRepository;
use App\Repository\PriceCategoryRepository;
use App\Repository\ServiceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class ServiceController extends AbstractController
{
    #[Route('/services', name: 'services')]
    public function index(
        ServiceRepository $serviceRepository,
        ClinicRepository $clinicRepository,
        ClinicRatingRepository $ratingRepository
    )
    {
        return $this->render('service/index.html.twig', [
            'services' => $serviceRepository->findBy(['parent' => null]),
            'totalClinics' => $clinicRepository->count([]),
            'ratings' => $ratingRepository->findAll(),
        ]);
    }

    /**
     * @Route("/service/{path}", name="service.show", requirements={"path":".+"})
     */
    public function show(
        $path,
        ServiceRepository $serviceRepository,
        ClinicRepository $clinicRepository,
        PriceCategoryRepository $priceCategoryRepository,
        ClinicRatingRepository $ratingRepository,
        ArticleRepository $articleRepository
    )
    {
        $path = rtrim($path, '/');
        $service = null;
        $parent = null;

        // TODO: Перенести в репо
        foreach (explode('/', $path) as $slug) {
            $service = $serviceRepository->findOneBy(['parent' => $parent, 'slug' => $slug]);
            $parent = $service;
        }

        if (! $service) {
            throw new  NotFoundHttpException();
        }

        $price = null;

        $otherServices = $serviceRepository->getOtherServices([$service->getId()]);

        if ($service->getPriceItems()->count()) {
            $price = $priceCategoryRepository->getForPrice([
                'items' => $service->getPriceItems()->map(function ($val) {
                    return $val->getId();
                })->toArray()
            ]);
        }

        return $this->render('service/show.html.twig', [
                'service' => $service,
                'totalClinics' => $clinicRepository->count([]),
                'price' => $price,
                'ratings' => $ratingRepository->findAll(),
                'popularArticles' => $articleRepository->getPopular(),
                'otherServices' => $otherServices,
            ]
        );
    }
}
