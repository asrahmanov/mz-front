<?php

namespace App\Controller\Admin;

class PriceTagController extends AdminController
{
    protected function getEntityClass()
    {
        return \App\Entity\PriceTag::class;
    }

    protected function getForm()
    {
        return \App\Form\Admin\PriceTagType::class;
    }
}
