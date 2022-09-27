<?php

namespace App\Form\Admin;

use App\Entity\QA;
use App\Form\Admin\Field\DatePickerType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Routing\RouterInterface;

class QAType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('isPublicationAllowed')
            ->add('isPublished')
            ->add('createdAt', DatePickerType::class)
            ->add('authorName')
            ->add('authorEmail')
            ->add('questionText')
            ->add('answerText')
            ->add('answerAuthor')
            ->add('branches', null, ['attr' => ['data-controller' => 'select2']])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => QA::class,
        ]);
    }
}
