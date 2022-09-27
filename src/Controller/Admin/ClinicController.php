<?php

namespace App\Controller\Admin;

class ClinicController extends AdminController
{
    protected function getEntityClass()
    {
        return \App\Entity\Clinic::class;
    }

    protected function getForm()
    {
        return \App\Form\Admin\ClinicType::class;
    }

    protected function setIndexFields(IndexFieldsBuilder $builder)
    {
        $builder
            ->add('name', 'Название')
            ->add('isMain', 'Основная');
    }
}
