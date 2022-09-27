<?php

namespace App\Form\Admin;

use App\Entity\Hardware;
use App\Form\Admin\Field\CollectionType;
use App\Form\Admin\Field\ImageType;
use App\Form\Admin\Field\WysiwygType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class HardwareType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', null, ['required' => true])
            ->add('manufacturer')
            ->add('image', ImageType::class, [
                'width' => '300px',
                'height' => '300px',
            ])
            ->add('advantages', CollectionType::class, [
                'entry_type' => HardwareAdvantagesType::class,
                'row_attr' => ['class' => ['d-flex']]
            ])
            ->add('content', WysiwygType::class, ['options' => ['body_class' => 'item-equipment _wysiwyg']])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Hardware::class,
            'attr' => ['novalidate' => 'novalidate'],
        ]);
    }
}
