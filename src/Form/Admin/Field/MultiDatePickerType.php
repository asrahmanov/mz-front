<?php


namespace App\Form\Admin\Field;


use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Extension\Core\Type\BaseType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MultiDatePickerType extends DatePickerType  implements DataTransformerInterface
{
    const SEPARATOR = ', ';

    protected function getOptions()
    {
        return array_merge(parent::getOptions(), ['multidate' => true,]);
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

        $result = '';
        foreach ($value as $item) {
            if ($result) {
                $result = implode(self::SEPARATOR, [$result, $item->format(self::DATE_FORMAT)]);
            }
            else {
                $result = $item->format(self::DATE_FORMAT);
            }
        }
        return $result;
    }

    public function reverseTransform($value)
    {
        if (! $value) {
            return [];
        }

        $result = [];

        foreach (explode(self::SEPARATOR, $value) as $item) {
            $result[] = \DateTime::createFromFormat(self::DATE_FORMAT, $item);
        }

        return $result;
    }
}
