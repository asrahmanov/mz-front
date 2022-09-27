<?php


namespace App\Form\Admin\Field;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;

class MenuType extends AbstractType implements DataTransformerInterface
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->addModelTransformer($this);
    }

    public function getParent()
    {
        return TextType::class;
    }

    public function transform($value)
    {
        return json_encode($value);
    }

    public function reverseTransform($value)
    {
        return $value ? json_decode($value) : json_encode([]);
    }
}
