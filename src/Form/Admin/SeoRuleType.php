<?php

namespace App\Form\Admin;

use App\Entity\SeoRule;
use App\Form\Admin\Field\WysiwygType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SeoRuleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('path',TextType::class,["help"=>"Например: /doctors","label"=>"Путь до страницы"])
            ->add('title')
            ->add('description')
            ->add('h1')
            ->add('canonical')
            ->add('robots', TextareaType::class, ['required' => false])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => SeoRule::class,
        ]);
    }
}
