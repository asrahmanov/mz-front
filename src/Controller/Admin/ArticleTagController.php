<?php

namespace App\Controller\Admin;

class ArticleTagController extends AdminController
{
    protected function getEntityClass()
    {
        return \App\Entity\ArticleTag::class;
    }

    protected function getForm()
    {
        return \App\Form\Admin\ArticleTagType::class;
    }
}
