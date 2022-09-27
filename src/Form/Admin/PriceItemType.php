<?php

namespace App\Form\Admin;

use App\Entity\PriceItem;
use App\Form\Admin\Field\JSTableType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PriceItemType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('oldValue')
            ->add('value')
            ->add('priceIsFrom')
            ->add('promo')
            ->add('new')
            ->add('additionalServices', JSTableType::class, ['options' => [
                'colHeaders' => ['Название услуги', 'Время'],
                'columns' => [
                    ['data' => 'name'],
                    ['data' => 'time'],
                ]
            ]])
            ->add('category', null, ['attr' => ['data-controller' => 'select2'], 'required' => true])
            ->add('doctors', null, ['attr' => ['data-controller' => 'select2']])
            ->add('tags', null, ['attr' => ['data-controller' => 'select2']])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => PriceItem::class,
        ]);
    }
}
