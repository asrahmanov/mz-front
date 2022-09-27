<?php

namespace App\Controller\Admin;

class DiseaseCategoryController extends AdminController
{
    protected function getEntityClass()
    {
        return \App\Entity\DiseaseCategory::class;
    }

    protected function getForm()
    {
        return \App\Form\Admin\DiseaseCategoryType::class;
    }
}
