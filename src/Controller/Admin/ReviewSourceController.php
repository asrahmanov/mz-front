<?php

namespace App\Controller\Admin;

class ReviewSourceController extends AdminController
{
    protected function getEntityClass()
    {
        return \App\Entity\ReviewSource::class;
    }

    protected function getForm()
    {
        return \App\Form\Admin\ReviewSourceType::class;
    }
}
