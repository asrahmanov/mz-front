<?php

namespace App\Form\Admin;

use App\Entity\CallbackRequest;
use App\Form\Admin\Field\DateTimeType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CallbackRequestType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('createdAt', DateTimeType::class)
            ->add('clientName')
            ->add('clientTel')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => CallbackRequest::class,
        ]);
    }
}
