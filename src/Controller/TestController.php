<?php


namespace App\Controller;


use App\Entity\Doctor;
use PhpParser\Comment\Doc;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class TestController extends AbstractController
{
    /**
     * @Route("/")
     */
    public function index()
    {
        return $this->render('test.html.twig',[
            'doctor' => $this->getDoctrine()->getRepository(Doctor::class)->findOneBy([])
        ]);
    }
}
