<?php

namespace App\Controller\Admin;

class ServiceController extends AdminController
{
    protected function getEntityClass()
    {
        return \App\Entity\Service::class;
    }

    protected function getForm()
    {
        return \App\Form\Admin\ServiceType::class;
    }
}
