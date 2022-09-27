<?php

namespace App\Form\Admin;

use App\Entity\ClinicRating;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ClinicRatingType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('score', NumberType::class, [
                'html5' => true,
                'attr' => [
                    'min' => 1,
                    'max' => 5,
                    'step' => 0.1
                ]
            ])
            ->add('source', null, ['attr' => ['data-controller' => 'select2']]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ClinicRating::class,
        ]);
    }
}
