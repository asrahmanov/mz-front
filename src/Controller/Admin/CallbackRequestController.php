<?php

namespace App\Controller\Admin;

class CallbackRequestController extends AdminController
{
    protected function getEntityClass()
    {
        return \App\Entity\CallbackRequest::class;
    }

    protected function getForm()
    {
        return \App\Form\Admin\CallbackRequestType::class;
    }

    protected function getIndexTemplate()
    {
        return 'admin/entity/callback_request/index.html.twig';
    }

    protected function setIndexFields(IndexFieldsBuilder $builder)
    {
        $builder
            ->add('id', '#')
            ->add('createdAt', 'Создана')
            ->add('clientName', 'Имя клиента')
            ->add('clientTel', 'Телефон клиента')
        ;
    }
}
