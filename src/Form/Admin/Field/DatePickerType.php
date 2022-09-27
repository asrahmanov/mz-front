<?php


namespace App\Form\Admin\Field;


use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Extension\Core\Type\BaseType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DatePickerType extends BaseType  implements DataTransformerInterface
{
    const DATE_FORMAT = 'd.m.Y';

    protected function getOptions()
    {
        return [
            'todayHighlight' => true,
        ];
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefault('required', false);
    }

    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['attr'] = array_merge($view->vars['attr'],  [
            'data-controller' => 'datepicker',
            'data-datepicker-opts-value' => json_encode(static::getOptions()),
        ]);
    }

    public function getParent()
    {
        return TextType::class;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->addViewTransformer($this);
    }

    public function transform($value)
    {
        if (! $value) {
            return null;
        }
        return $value->format(self::DATE_FORMAT);
    }

    public function reverseTransform($value)
    {
        if (! $value) {
            return null;
        }

        return \DateTime::createFromFormat(self::DATE_FORMAT, $value);
    }
}
