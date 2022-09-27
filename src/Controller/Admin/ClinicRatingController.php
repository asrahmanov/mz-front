<?php

namespace App\Controller\Admin;

class ClinicRatingController extends AdminController
{
    protected function getEntityClass()
    {
        return \App\Entity\ClinicRating::class;
    }

    protected function getForm()
    {
        return \App\Form\Admin\ClinicRatingType::class;
    }
}
