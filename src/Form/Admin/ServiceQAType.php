<?php

namespace App\Form\Admin;

use App\Entity\ServiceQA;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ServiceQAType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('questionText')
            ->add('answerText')
            ->add('answerAuthor')
            ->add('services', null, [
                'attr' => ['data-controller' => 'select2'],
                'by_reference' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ServiceQA::class,
        ]);
    }
}
