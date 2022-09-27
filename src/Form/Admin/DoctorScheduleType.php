<?php

namespace App\Form\Admin;

use App\Entity\DoctorSchedule;
use App\Entity\DoctorScheduleDate;
use App\Form\Admin\Field\DatePickerType;
use App\Form\Admin\Field\MultiDatePickerType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DoctorScheduleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('doctor', null, ['attr' => ['data-controller' => 'select2']])
            ->add('clinic', null, [
                'attr' => ['data-controller' => 'select2'],
                'required' => true,
            ])
            ->add('dates', MultiDatePickerType::class)
            ->get('dates')->addModelTransformer(new CallbackTransformer(
                function($value) {
                    $result = [];
                    foreach ($value as $item) {
                        $result[] = $item->getDate();
                    }
                    return $result;
                },
                function ($value) {
                    $result = [];

                    foreach ($value as $item) {
                        $result[] = (new DoctorScheduleDate())->setDate($item);
                    }
                    return $result;
                }
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => DoctorSchedule::class,
        ]);
    }
}
