<?php


namespace App\Form\Admin\Field;


use Symfony\Component\Form\Extension\Core\Type\BaseType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CollectionType extends BaseType
{
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'col' => 12,
            'allow_add' => true,
            'allow_delete' => true,
            'delete_empty' => true,
        ]);
    }

    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['col'] = $options['col'];
    }

    public function getParent()
    {
        return \Symfony\Component\Form\Extension\Core\Type\CollectionType::class;
    }
}
