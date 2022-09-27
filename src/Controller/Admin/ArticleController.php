<?php

namespace App\Controller\Admin;

class ArticleController extends AdminController
{
    protected function getEntityClass()
    {
        return \App\Entity\Article::class;
    }

    protected function getForm()
    {
        return \App\Form\Admin\ArticleType::class;
    }
}
