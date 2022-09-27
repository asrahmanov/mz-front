<?php

namespace App\Form\Admin;

use App\Entity\Banner;
use App\Entity\Promo;
use App\Form\Admin\Field\ImageType;
use App\Repository\BannerRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\ChoiceList\Loader\CallbackChoiceLoader;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BannerType extends AbstractType
{
    static $LOCATION_LIST = [
        'Страница списка врачей (640 X 778px)' => 'doctors_page_1',
        'Страница врача, баннер 1' => 'doctor_page_1',
        'Страница врача, баннер 2' => 'doctor_page_2',
        'Страница врача, баннер 3' => 'doctor_page_3',
        'Страница заболевания' => 'disease_page_1',
        'Страница метода лечения, баннер 1' => 'treatment_page_1',
        'Страница метода лечения, баннер 2' => 'treatment_page_2',
        'Страница метода лечения, баннер 3' => 'treatment_page_3',
        'Страница отделения, баннер 1' => 'branch_page_1',
        'Страница отделения, баннер 2' => 'branch_page_2',
        'Страница отделения, баннер 3' => 'branch_page_3',
        'Страница блога' => 'article_page_1',
    ];
    protected BannerRepository $repository;

    public function __construct(BannerRepository $repository)
    {
        $this->repository = $repository;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('location', ChoiceType::class, [
                'required' => false,
                'attr' => ['data-controller' => 'select2'],
                'choice_loader' => new CallbackChoiceLoader(function () use ($options) {
                    $currentChoice = $options['data'] ? $options['data']->getLocation() : null;
                    $usedChoices = $this->repository->createQueryBuilder('b')
                        ->select('b.location')
                        ->where('b.location IS NOT NULL')
                        ->getQuery()
                        ->getScalarResult()
                    ;
                    $usedChoices = array_column($usedChoices, 'location');
                    return array_filter(self::$LOCATION_LIST, function($el) use ($usedChoices, $currentChoice) {
                        return  $el === $currentChoice || (! in_array($el, $usedChoices));
                    });
                })
            ])
            ->add('image', ImageType::class, ['width' => '100%', 'height' => '300px'])
            ->add('promo', null, ['attr' => ['data-controller' => 'select2']]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Banner::class,
        ]);
    }
}
