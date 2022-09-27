<?php

namespace App\Controller\Admin;

class ReviewController extends AdminController
{
    protected function getEntityClass()
    {
        return \App\Entity\Review::class;
    }

    protected function getForm()
    {
        return \App\Form\Admin\ReviewType::class;
    }

    protected function setIndexFields(IndexFieldsBuilder $builder)
    {
        $builder->add('createdAt', 'Дата создания');
        $builder->add('authorName', 'Имя автора');
        $builder->add('shortText', 'Текст');
    }
}
