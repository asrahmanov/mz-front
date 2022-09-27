<?php

namespace App\Form\Admin;

use App\Entity\MainSliderSlide;
use App\Form\Admin\Field\ImageType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Expression;
use Symfony\Component\Validator\Constraints\NotBlank;

class MainSliderSlideType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('image', ImageType::class, [
                'width' => '100%', 'height' => '300px', 'help' => '1312 × 486 px',
                'required' => true,
                'constraints' => [
                    new Expression('value["url"] != null', 'Поле Изображение обязательно к заполнению'),
                ],
            ])
            ->add('promo', null, ['attr' => ['data-controller' => 'select2']])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => MainSliderSlide::class,
            'attr' => ['novalidate' => 'novalidate']
        ]);
    }
}
