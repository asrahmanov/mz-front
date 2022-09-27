<?php

namespace App\Controller\Admin;

class LetterToDirectorController extends AdminController
{
    protected function getEntityClass()
    {
        return \App\Entity\LetterToDirector::class;
    }

    protected function getForm()
    {
        return \App\Form\Admin\LetterToDirectorType::class;
    }
}
