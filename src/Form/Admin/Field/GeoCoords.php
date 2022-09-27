<?php


namespace App\Form\Admin\Field;


use App\Form\Admin\Transformer\ObjectToJsonStringTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;

class GeoCoords extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->addModelTransformer(new ObjectToJsonStringTransformer());
    }

    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars = array_merge($view->vars, ['attr' => ['class' => 'geo-coords']]);
    }

    public function getParent()
    {
        return TextType::class;
    }
}
