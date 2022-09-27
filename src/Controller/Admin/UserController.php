<?php


namespace App\Controller\Admin;


use App\Entity\User;
use App\Form\Admin\UserType;

class UserController extends AdminController
{
    protected function getEntityClass()
    {
        return User::class;
    }

    protected function getForm()
    {
        return UserType::class;
    }
}