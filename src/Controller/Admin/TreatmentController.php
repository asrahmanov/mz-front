<?php

namespace App\Controller\Admin;

class TreatmentController extends AdminController
{
    protected function getEntityClass()
    {
        return \App\Entity\Treatment::class;
    }

    protected function getForm()
    {
        return \App\Form\Admin\TreatmentType::class;
    }
}
