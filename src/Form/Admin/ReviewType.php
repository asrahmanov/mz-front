<?php

namespace App\Form\Admin;

use App\Entity\Review;
use App\Form\Admin\Field\DatePickerType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ReviewType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('createdAt', DatePickerType::class)
            ->add('isPublished')
            ->add('authorName')
            ->add('text')
            ->add('video')
            ->add('answerText')
            ->add('rating', null, ['html5' => true, 'attr' => ['min' => 1, 'max' => 5, 'step' => '0.1']])
            ->add('clinic', null, ['attr' => ['data-controller' => 'select2']])
            ->add('doctors', null, ['attr' => ['data-controller' => 'select2']])
            ->add('source', null, ['attr' => ['data-controller' => 'select2']])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Review::class,
        ]);
    }
}
