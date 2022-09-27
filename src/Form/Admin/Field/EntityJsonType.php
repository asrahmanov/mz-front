<?php


namespace App\Form\Admin\Field;


use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class EntityJsonType extends AbstractType
{
    public function getParent()
    {
        return EntityType::class;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->resetViewTransformers();
    }
}
