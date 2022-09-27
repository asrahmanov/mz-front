<?php

namespace App\Form;

use App\Entity\Clinic;
use App\Entity\Doctor;
use App\Entity\Specialty;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ReviewFilterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('specialty', EntityType::class, [
                'class' => Specialty::class,
                'required' => false,
            ])
            ->add('doctor', EntityType::class, [
                'class' => Doctor::class,
                'required' => false
            ])
            ->add('clinic', EntityType::class, [
                'class' => Clinic::class,
                'required' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'allow_extra_fields' => true,
        ]);
    }
}