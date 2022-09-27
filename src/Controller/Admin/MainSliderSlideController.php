<?php

namespace App\Controller\Admin;

class MainSliderSlideController extends AdminController
{
    protected function getEntityClass()
    {
        return \App\Entity\MainSliderSlide::class;
    }

    protected function getForm()
    {
        return \App\Form\Admin\MainSliderSlideType::class;
    }

    protected function setIndexFields(IndexFieldsBuilder $builder)
    {
        $builder->add('promo','Акция');
    }
}
