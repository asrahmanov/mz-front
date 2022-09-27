<?php


namespace App\Controller\Admin;


use App\Entity\DoctorSchedule;
use App\Form\Admin\DoctorScheduleType;

class DoctorScheduleController extends AdminController
{
    protected function getForm()
    {
        return DoctorScheduleType::class;
    }

    protected function getEntityClass()
    {
        return DoctorSchedule::class;
    }
}