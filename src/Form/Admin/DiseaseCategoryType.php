<?php

namespace App\Form\Admin;

use App\Entity\DiseaseCategory;
use App\Form\Admin\Field\SlugType;
use App\Form\Admin\Field\WysiwygType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DiseaseCategoryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('slug', SlugType::class, ['target' => '#disease_category_name'])
            ->add('doctors', null, ['attr' => ['data-controller' => 'select2']])
            ->add('content', WysiwygType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => DiseaseCategory::class,
        ]);
    }
}
