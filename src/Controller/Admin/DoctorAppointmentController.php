<?php

namespace App\Controller\Admin;

class DoctorAppointmentController extends AdminController
{
    protected function getEntityClass()
    {
        return \App\Entity\DoctorAppointment::class;
    }

    protected function getForm()
    {
        return \App\Form\Admin\DoctorAppointmentType::class;
    }

    protected function getIndexTemplate()
    {
        return 'admin/entity/callback_request/index.html.twig';
    }

    protected function setIndexFields(IndexFieldsBuilder $builder)
    {
        $builder
            ->add('id', '#')
            ->add('date', 'Дата записи')
            ->add('doctor', 'Врач', 'fullName')
            ->add('clinic', 'Клиника', 'name')
        ;
    }
}
