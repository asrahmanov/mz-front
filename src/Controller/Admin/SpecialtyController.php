<?php

namespace App\Controller\Admin;

class SpecialtyController extends AdminController
{
    protected function getEntityClass()
    {
        return \App\Entity\Specialty::class;
    }

    protected function getForm()
    {
        return \App\Form\Admin\SpecialtyType::class;
    }
}
