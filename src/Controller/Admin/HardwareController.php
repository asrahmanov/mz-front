<?php

namespace App\Controller\Admin;

class HardwareController extends AdminController
{
    protected function getEntityClass()
    {
        return \App\Entity\Hardware::class;
    }

    protected function getForm()
    {
        return \App\Form\Admin\HardwareType::class;
    }
}
