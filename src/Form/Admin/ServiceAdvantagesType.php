<?php


namespace App\Form\Admin;


use App\Form\Admin\Field\ImageType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;

class ServiceAdvantagesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('image', ImageType::class);
        $builder->add('text', TextareaType::class);
    }
}
