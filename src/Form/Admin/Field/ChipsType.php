<?php


namespace App\Form\Admin\Field;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\ChoiceList\ChoiceList;
use Symfony\Component\Form\ChoiceList\Loader\CallbackChoiceLoader;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ChipsType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefault('multiple', true);
        $resolver->setDefault('compound', false);
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->resetViewTransformers();
    }

    public function getParent()
    {
        return ChoiceType::class;
    }
}
