<?php

namespace App\Controller\Admin;

class QAController extends AdminController
{
    protected function getEntityClass()
    {
        return \App\Entity\QA::class;
    }

    protected function getForm()
    {
        return \App\Form\Admin\QAType::class;
    }
}
