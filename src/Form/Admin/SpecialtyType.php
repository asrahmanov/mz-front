<?php

namespace App\Form\Admin;

use App\Entity\Specialty;
use App\Form\Admin\Field\SlugType;
use App\Form\Admin\Field\WysiwygType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SpecialtyType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('namePlural')
            ->add('slug', SlugType::class, [
                'target' => '#specialty_name',
                'required' => true,
            ])
            ->add('content', WysiwygType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Specialty::class,
        ]);
    }
}
