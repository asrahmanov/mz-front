<?php


namespace App\Form\Admin\Field;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;


class CropperType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver)
    {
        return $resolver->setDefault('required', false);
    }

    public function getParent()
    {
        return TextType::class;
    }
}
