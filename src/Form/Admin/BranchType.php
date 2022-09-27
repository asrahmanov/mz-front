<?php

namespace App\Form\Admin;

use App\Entity\Branch;
use App\Form\Admin\Field\CollectionType;
use App\Form\Admin\Field\ImageType;
use App\Form\Admin\Field\SlugType;
use App\Form\Admin\Field\WysiwygType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BranchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('slug', SlugType::class, ['target' => '#branch_name'])
            ->add('image1', ImageType::class, ['width' => '150px', 'height' => '150px'])
            ->add('image2', ImageType::class, ['width' => '150px', 'height' => '150px'])
            ->add('excerpt', WysiwygType::class)
            ->add('content', WysiwygType::class)
            ->add('clinics', null, ['attr' => ['data-controller' => 'select2']])
            ->add('doctors', null, ['attr' => ['data-controller' => 'select2']])
            ->add('symptoms', CollectionType::class, [
                'attr' => ['data-controller' => 'select2'],
                'entry_type' => SymptomType::class,
                'col' => 6
            ])
            ->add('diseases', null, ['attr' => ['data-controller' => 'select2']])
            ->add('services', null, [
                'attr' => ['data-controller' => 'select2'],
                'label' => 'Услуги диагностики',
            ])
            ->add('hardware', null, ['attr' => ['data-controller' => 'select2']])
            ->add('treatmentsText', WysiwygType::class, ['label' => 'Текст, сопровождающий список методов течения'])
            ->add('treatments', null, ['attr' => ['data-controller' => 'select2']])
            ->add('priceItems', null, ['attr' =>  ['data-controller' => 'select2']])
            ->add('reviews', null, ['attr' => ['data-controller' => 'select2']])
            ->add('articles', null, ['attr' => ['data-controller' => 'select2']])
            ->add('qAs', null, ['attr' => ['data-controller' => 'select2']])
            ->add('showInMainPage')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Branch::class,
        ]);
    }
}
