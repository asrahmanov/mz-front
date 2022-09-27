<?php


namespace App\Form\Admin\Field;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DateTimeType extends AbstractType implements DataTransformerInterface
{
    const DATE_FORMAT = 'd.m.Y H:i:s';
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefault('attr' , ['class' => 'date-picker'])
            ->setDefault('required', false)
        ;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->addViewTransformer($this);
    }

    public function getParent()
    {
        return TextType::class;
    }

    public function getBlockPrefix()
    {
        return 'date_picker';
    }

    public function transform($value)
    {
        return $value ? $value->format(self::DATE_FORMAT) : '';
    }

    public function reverseTransform($value)
    {
        return $value ? \DateTime::createFromFormat(self::DATE_FORMAT, $value) : null;
    }
}
