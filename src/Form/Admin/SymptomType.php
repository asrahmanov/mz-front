<?php

namespace App\Form\Admin;

use App\Entity\Symptom;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SymptomType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('description')
            ->add('hazard', ChoiceType::class, [
                'attr' => ['data-controller' => 'select2'],
                'choices' => [
                    'Не опасный' => 0,
                    'Пора к врачу' => 1,
                    'Опасный' => 2,
                ]])
            ->add('location', ChoiceType::class, [
                'attr' => ['data-controller' => 'select2'],
                'choices' => [
                    'Головные боли (боли в висках)' => 1,
                    'Болят плечи' => 2,
                    'Боль в груди' => 3,
                    'Болят локти' => 4,
                    'Болят запястья' => 5,
                    'Болят тазобедренные суставы' => 6,
                    'Болят ладони, кисти рук и суставы пальцев' => 7,
                    'Болят колени' => 8,
                    'Болят пальцы ног (суставы)' => 9,

                    'Боли в затылке' => 10,
                    'Боли в шее' => 11,
                    'Боль между лопатками, боль под лопаткой' => 12,
                    'Боли в спине, боль в позвоночнике' => 13,
                    'Боль в пояснице, прострел поясницы' => 14,
                    'Болят бёдра' => 15,
                    'Болят ноги, болят голени' => 16,
                    'Болят стопы' => 17,
                ]]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Symptom::class,
        ]);
    }
}
