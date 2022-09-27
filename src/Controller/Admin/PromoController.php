<?php

namespace App\Controller\Admin;

class PromoController extends AdminController
{
    protected function getEntityClass()
    {
        return \App\Entity\Promo::class;
    }

    protected function getForm()
    {
        return \App\Form\Admin\PromoType::class;
    }
}
