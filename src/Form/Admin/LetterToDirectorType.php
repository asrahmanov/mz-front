<?php

namespace App\Form\Admin;

use App\Entity\LetterToDirector;
use App\Form\Admin\Field\DateTimeType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LetterToDirectorType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('createdAt', DateTimeType::class)
            ->add('authorName')
            ->add('authorTel')
            ->add('text')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => LetterToDirector::class,
        ]);
    }
}
