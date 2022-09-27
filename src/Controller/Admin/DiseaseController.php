<?php

namespace App\Controller\Admin;

class DiseaseController extends AdminController
{
    protected function getEntityClass()
    {
        return \App\Entity\Disease::class;
    }

    protected function getForm()
    {
        return \App\Form\Admin\DiseaseType::class;
    }
}
