<?php

namespace App\Form\Admin;

use App\Entity\Clinic;
use App\Form\Admin\Field\CollectionType;
use App\Form\Admin\Field\GeoCoords;
use App\Form\Admin\Field\ImageType;
use App\Form\Admin\Field\SlugType;
use App\Form\Admin\Field\WysiwygType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ClinicType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', null, ['help' => 'Например: "На Академической"'])
            ->add('slug', SlugType::class, ['target' => '#clinic_name'])
            ->add('legalName')
            ->add('photo', ImageType::class, ['width' => '200px', 'height' => '200px'])
            ->add('address')
            ->add('distance', null, ['label' => 'Расстояние от метро'])
            ->add('color', ChoiceType::class, [
                'attr' => ['data-controller' => 'select2'],
                'label' => 'Цвет линии метро',
                'choices' => [
                    'Красный' => 'red',
                    'Синий' => 'blue',
                    'Зеленый' => 'green',
                    'Желтый' => 'yellow',
                    'Фиолетовый' => 'purple',
            ]])
            ->add('certs', CollectionType::class, [
                'attr' => ['data-controller' => 'select2'],
                'by_reference' => false,
                'entry_type' => CertType::class,
                'col' => 3
            ])
            ->add('tel')
            ->add('socVk')
            ->add('socFb')
            ->add('socYoutube')
            ->add('socInsta')
            ->add('socTelegram')
            ->add('contactInfo', WysiwygType::class)
            ->add('parkingInfo', WysiwygType::class)
            ->add('legalInfo', WysiwygType::class)
            ->add('gallery', CollectionType::class, [
                'entry_type' => ImageType::class,
                'col' => 3,
                'entry_options' => [
                    'height' => '200px'
                ]
            ])
            ->add('coords', GeoCoords::class, [
                'label' => 'Координаты клиники',
                'required' => true,
            ])
            ->add('parkingCoords', GeoCoords::class, [
                'label' => 'Координаты парковки',
                'required' => false
            ])
            ->add('isMain', null, ['label' => 'Основная клиника'])
//            ->add('branches')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Clinic::class,
        ]);
    }
}
