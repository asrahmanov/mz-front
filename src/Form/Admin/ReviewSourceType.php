<?php

namespace App\Form\Admin;

use App\Entity\ReviewSource;
use App\Form\Admin\Field\ImageType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ReviewSourceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('logo', ImageType::class, ['width' => '100px', 'height' => '100px'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ReviewSource::class,
        ]);
    }
}
