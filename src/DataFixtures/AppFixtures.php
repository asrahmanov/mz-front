<?php

namespace App\DataFixtures;

use App\Entity\Clinic;
use App\Entity\Doctor;
use App\Entity\Menu;
use App\Entity\ReviewSource;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\ORM\Mapping\EntityResult;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\String\Slugger\SluggerInterface;

class AppFixtures extends Fixture
{
    private $slugger;

    public function __construct(SluggerInterface $slugger)
    {
        $this->slugger = $slugger;
    }

    public function load(ObjectManager $manager)
    {
        $menu = (new Menu())
            ->setSlug('main-menu')
            ->setName('Главное меню')
            ->setData([
                [
                    'name' => 'О клиники',
                    'link' => '#',
                ],
                [
                    'name' => 'Услуги',
                    'link' => '/services',
                ],
                [
                    'name' => 'Цены',
                    'link' => '/prices',
                ],
                [
                    'name' => 'Акции',
                    'link' => '/promos',
                ],
                [
                    'name' => 'Врачи',
                    'link' => '/doctors',
                ],
//                [
//                    'name' => 'Наш блог',
//                    'link' => '/articles',
//                ],
                [
                    'name' => 'Отзывы',
                    'link' => '#',
                ],
                [
                    'name' => 'Контакты',
                    'link' => '/contacts',
                ],
            ]);
        $manager->persist($menu);

        $bottomMenu = (new Menu())
            ->setSlug('bottom-menu')
            ->setName('Нижнее меню')
            ->setData([
                [
                    'name' => 'О клиники',
                    'link' => '/about',
                ],
                [
                    'name' => 'Услуги',
                    'link' => '/services',
                ],
                [
                    'name' => 'Цены',
                    'link' => '/prices',
                ],
                [
                    'name' => 'Акции',
                    'link' => '/promos',
                ],
                [
                    'name' => 'Врачи',
                    'link' => '/doctors',
                ],
//                [
//                    'name' => 'Наш блог',
//                    'link' => '/articles',
//                ],
                [
                    'name' => 'Отзывы',
                    'link' => '/reviews',
                ],
                [
                    'name' => 'Контакты',
                    'link' => '/contacts',
                ],
            ]);
        $manager->persist($menu);
        $manager->persist($bottomMenu);

        $ratingSource = (new ReviewSource())
            ->setName('MZ-Clinic')
            ->setLogo([
                'url' => '/img/rating-clinic/mzc.svg',
                'alt' => 'mz-clinic'
            ])
        ;
        $manager->persist($ratingSource);

        $manager->flush();
    }
}
