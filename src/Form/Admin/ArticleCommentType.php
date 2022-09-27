<?php

namespace App\Form\Admin;

use App\Entity\ArticleComment;
use App\Form\Admin\Field\DatePickerType;
use App\Form\Admin\Field\WysiwygType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArticleCommentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('isPublished')
            ->add('article', null, ['attr' => ['data-controller' => 'select2']])
            ->add('createdAt', DatePickerType::class)
            ->add('authorName')
            ->add('text')
            ->add('authorTel', TelType::class, ['required' => false])
            ->add('answerDate', DatePickerType::class)
            ->add('answerText')
            ->add('answerAuthor', null, ['attr' => ['data-controller' => 'select2']])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ArticleComment::class,
        ]);
    }
}
