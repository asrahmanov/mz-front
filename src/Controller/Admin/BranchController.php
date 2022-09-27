<?php

namespace App\Controller\Admin;

class BranchController extends AdminController
{
    protected function getEntityClass()
    {
        return \App\Entity\Branch::class;
    }

    protected function getForm()
    {
        return \App\Form\Admin\BranchType::class;
    }
}
