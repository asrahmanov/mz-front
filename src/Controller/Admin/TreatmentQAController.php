<?php

namespace App\Controller\Admin;

class TreatmentQAController extends AdminController
{
    protected function getEntityClass()
    {
        return \App\Entity\TreatmentQA::class;
    }

    protected function getForm()
    {
        return \App\Form\Admin\TreatmentQAType::class;
    }

    function setIndexFields(IndexFieldsBuilder $builder)
    {
        $builder->add('id', '#')
            ->add('questionText', 'Название')
            ->add('treatmentsList', 'Методы лечения')
        ;
    }
}
