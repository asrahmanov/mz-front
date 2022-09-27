<?php


namespace App\Form\Admin\Field;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SlugType extends AbstractType
{

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setRequired('target');
        $resolver->setDefault('attr', ['class' => 'slug']);
    }

    public function getParent()
    {
        return TextType::class;
    }

    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['attr']['data-target'] = $options['target'];
    }
}
