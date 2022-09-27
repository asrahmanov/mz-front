<?php

namespace App\Controller\Admin;

class BannerController extends AdminController
{
    protected function getEntityClass()
    {
        return \App\Entity\Banner::class;
    }

    protected function getForm()
    {
        return \App\Form\Admin\BannerType::class;
    }

    protected function setIndexFields(IndexFieldsBuilder $builder)
    {
        $builder->add('promo', 'Акция')
            ->add('locationLabel', 'Расположение')
        ;
    }
}
