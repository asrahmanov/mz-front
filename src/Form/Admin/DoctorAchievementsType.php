<?php


namespace App\Form\Admin;


use App\Form\Admin\Field\ChipsType;
use App\Form\Admin\Field\CropperType;
use App\Form\Admin\Field\DropZoneType;
use App\Form\Admin\Field\ImageType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DoctorAchievementsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('image', ImageType::class);
        $builder->add('text', TextareaType::class);
    }
}
