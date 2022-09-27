<?php

namespace App\Controller\Admin;

class DoctorRatingController extends AdminController
{
    protected function getEntityClass()
    {
        return \App\Entity\DoctorRating::class;
    }

    protected function getForm()
    {
        return \App\Form\Admin\DoctorRatingType::class;
    }
}
