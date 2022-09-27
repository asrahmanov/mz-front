<?php

namespace App\Controller\Admin;

class ArticleCommentController extends AdminController
{
    protected function getEntityClass()
    {
        return \App\Entity\ArticleComment::class;
    }

    protected function getForm()
    {
        return \App\Form\Admin\ArticleCommentType::class;
    }
}
