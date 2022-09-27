<?php

namespace App\Controller\Admin;

class DiseaseCommentController extends AdminController
{
    protected function getEntityClass()
    {
        return \App\Entity\DiseaseComment::class;
    }

    protected function getForm()
    {
        return \App\Form\Admin\DiseaseCommentType::class;
    }
}
