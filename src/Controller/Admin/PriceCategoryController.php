<?php

namespace App\Controller\Admin;

class PriceCategoryController extends AdminController
{
    protected function getEntityClass()
    {
        return \App\Entity\PriceCategory::class;
    }

    protected function getForm()
    {
        return \App\Form\Admin\PriceCategoryType::class;
    }

    public function setIndexFields(IndexFieldsBuilder $builder): void
    {
        $builder
            ->add('id','#')
            ->add('name', 'Имя')
            ->add('parrentCategory', 'Родительская категория')
        ;
    }
}
