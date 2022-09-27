<?php

namespace App\Form\Admin;

use App\Entity\DiseaseComment;
use App\Form\Admin\Field\DatePickerType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DiseaseCommentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('authorName')
            ->add('authorTel')
            ->add('createdAt', DatePickerType::class)
            ->add('text')
            ->add('answerDate', DatePickerType::class)
            ->add('answerText')
            ->add('answerAuthor', null, ['attr' => ['data-controller' => 'select2']])
            ->add('disease', null, ['attr' => ['data-controller' => 'select2']])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => DiseaseComment::class,
        ]);
    }
}
