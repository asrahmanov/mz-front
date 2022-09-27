<?php

namespace App\Controller\Admin;

class ServiceQAController extends AdminController
{
    protected function getEntityClass()
    {
        return \App\Entity\ServiceQA::class;
    }

    protected function getForm()
    {
        return \App\Form\Admin\ServiceQAType::class;
    }
}
