<?php

namespace App\Form\Admin;

use App\Entity\TreatmentQA;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TreatmentQAType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('questionText')
            ->add('answerText')
            ->add('answerAuthor')
            ->add('treatments', null, [
                'attr' => ['data-controller' => 'select2'],
                'by_reference' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => TreatmentQA::class,
        ]);
    }
}
