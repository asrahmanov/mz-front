<?php

namespace App\Form\Admin;

use App\Entity\Promo;
use App\Form\Admin\Field\DatePickerType;
use App\Form\Admin\Field\ImageType;
use App\Form\Admin\Field\SlugType;
use App\Form\Admin\Field\WysiwygType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PromoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('slug', SlugType::class, ['target' => '#promo_name'])
            ->add('activeUntil', DatePickerType::class)
            ->add('image', ImageType::class, ['width' => '200px', 'height' => '200px'])
            ->add('content', WysiwygType::class)
            ->add('promo')
            ->add('specialPrice')
            ->add('new')
            ->add('onlineConsultation')
            ->add('excerpt', WysiwygType::class)
            ->add('clinics', null, ['attr' => ['data-controller' => 'select2']])
            ->add('other', null, ['attr' => ['data-controller' => 'select2']])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Promo::class,
        ]);
    }
}
