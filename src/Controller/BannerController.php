<?php


namespace App\Controller;


use App\Repository\BannerRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class BannerController extends AbstractController
{
    public function show(string $location, string $template, BannerRepository $repository)
    {
        $banner = $repository->findOneBy(['location' => $location]);
        if (! $banner) {
            return new Response();
        }

        return  $this->render($template, [
            'banner' => $banner,
        ]);
    }
}
