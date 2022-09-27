<?php

namespace App\Controller\Admin;

class MenuController extends AdminController
{
    protected function getEntityClass()
    {
        return \App\Entity\Menu::class;
    }

    protected function getForm()
    {
        return \App\Form\Admin\MenuType::class;
    }
}
