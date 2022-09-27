<?php

namespace App\Form\Admin;

use App\Entity\Treatment;
use App\Form\Admin\Field\ImageType;
use App\Form\Admin\Field\SlugType;
use App\Form\Admin\Field\WysiwygType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TreatmentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('slug', SlugType::class, ['target' => '#treatment_name'])
            ->add('image', ImageType::class, ['width' => '200px', 'height' => '300px'])
            ->add('excerpt', WysiwygType::class)
            ->add('video')
            ->add('duration')
            ->add('proceduresCount', null, ['label' => 'Количество процедур'])
            ->add('cost')
            ->add('courseCost', null, ['label' => 'Стоимость курса'])
            ->add('content', WysiwygType::class)
            ->add('indications', WysiwygType::class)
            ->add('contraindications', WysiwygType::class, ['options' => ['body_class' => 'indications__body_red _wysiwyg']])
            ->add('clinics', null, ['attr' => ['data-controller' => 'select2']])
            ->add('reviews', null, [
                'attr' => ['data-controller' => 'select2'],
                'label' => 'Отзывы'
            ])
            ->add('priceItems', null, [
                'attr' => ['data-controller' => 'select2'],
                'choice_label' => 'fullName',
            ])
            ->add('relatedTreatmentsText', WysiwygType::class,[
                'label' => 'Текст перед списком со связанными процедурами'
            ])
            ->add('relatedTreatments', null, [
                'attr' => ['data-controller' => 'select2'],
                'label' => 'Связанные процедуры'
            ])
            ->add('doctors', null, ['attr' => ['data-controller' => 'select2']])
            ->add('qAs', null, ['attr' => ['data-controller' => 'select2']])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Treatment::class,
        ]);
    }
}
