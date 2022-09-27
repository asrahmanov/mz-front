<?php

namespace App\Controller\Admin;

class PriceItemController extends AdminController
{
    protected function getEntityClass()
    {
        return \App\Entity\PriceItem::class;
    }

    protected function getForm()
    {
        return \App\Form\Admin\PriceItemType::class;
    }

    protected function getIndexTemplate()
    {
        return 'admin/entity/price_item/index.html.twig';
    }
}
