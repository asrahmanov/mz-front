<?php

namespace App\Controller\Admin;

class SymptomController extends AdminController
{
    protected function getEntityClass()
    {
        return \App\Entity\Symptom::class;
    }

    protected function getForm()
    {
        return \App\Form\Admin\SymptomType::class;
    }
}
