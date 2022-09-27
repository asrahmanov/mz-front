<?php


namespace App\Controller;


use App\Repository\MainSliderSlideRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class MainSliderController extends AbstractController
{
    public function show(MainSliderSlideRepository $repository)
    {
        $slider = $repository->findAll();

        if (! $slider) {
            return new Response();
        }

        return $this->render('_slider.html.twig', [
            'slider' => $slider,
        ]);
    }
}
