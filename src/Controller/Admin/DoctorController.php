<?php


namespace App\Controller\Admin;


use App\Entity\Doctor;
use App\Form\Admin\DoctorType;

class DoctorController extends AdminController
{
    protected function getEntityClass()
    {
        return Doctor::class;
    }

    protected function getForm()
    {
        return DoctorType::class;
    }

    protected function setIndexFields(IndexFieldsBuilder $builder)
    {
        $builder
            ->add('id', '#')
            ->add('fullName', 'ФИО');
    }
}
