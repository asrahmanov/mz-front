<?php

namespace App\Form\Admin;

use App\Entity\DoctorAppointment;
use App\Form\Admin\Field\DateType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DoctorAppointmentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('date', DateType::class)
            ->add('patientName')
            ->add('patientTel')
            ->add('doctor', null, ['attr' => ['data-controller' => 'select2']])
            ->add('clinic', null, ['attr' => ['data-controller' => 'select2']])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => DoctorAppointment::class,
        ]);
    }
}
