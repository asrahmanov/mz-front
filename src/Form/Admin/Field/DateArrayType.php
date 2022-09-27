<?php


namespace App\Form\Admin\Field;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DateArrayType extends AbstractType implements DataTransformerInterface
{
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefault('compound', false)
            ->setDefault('attr', [
                'class' => 'date-picker',
                'data-date-multidate' => 'true',
                'data-date-format' => 'yyyy-mm-dd',
            ])
        ;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->addViewTransformer($this);
    }

    /**
     * {@inheritdoc}
     */
    public function transform($data)
    {
        if (! $data) return '';
        return join(',', $data) ;
    }

    /**
     * {@inheritdoc}
     */
    public function reverseTransform($data)
    {
        return explode(',', $data);
    }
}
