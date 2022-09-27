<?php

namespace App\Form\Admin;

use App\Entity\Disease;
use App\Form\Admin\Field\CollectionType;
use App\Form\Admin\Field\DatePickerType;
use App\Form\Admin\Field\JSTableType;
use App\Form\Admin\Field\SlugType;
use App\Form\Admin\Field\WysiwygType;
use Carbon\Carbon;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DiseaseType extends AbstractType implements DataTransformerInterface
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('slug', SlugType::class, ['target' => '#disease_name'])
            ->add('categories', null, ['attr' => ['data-controller' => 'select2']])
            ->add('author', null, ['attr' => ['data-controller' => 'select2']])
            ->add('createdAt', DatePickerType::class)
            ->add('checkedAt', DatePickerType::class)
            ->add('updatedAt', DatePickerType::class)
            ->add('expert', null, ['attr' => ['data-controller' => 'select2']])
            ->add('expertComment')
            ->add('editor', null, ['attr' => ['data-controller' => 'select2']])
            ->add('treatmentText', WysiwygType::class)
            ->add('treatments', null, ['attr' => ['data-controller' => 'select2']])
            ->add('textBeforeServices', WysiwygType::class)
            ->add('services', null, ['attr' => ['data-controller' => 'select2']])
            ->add('excerpt')
            ->add('content', WysiwygType::class)
            ->add('viewsNum', NumberType::class, ['html5' => true, 'required' => false, 'attr' => ['min' => 0]])
            ->add('sources', JSTableType::class, ['options' => [
                'colHeaders' => ['Название', 'Ссылка'],
                'columns' => [
                    ['data' => 'name'],
                    ['data' => 'link'],
                ]
            ]])
            ->add('symptoms', CollectionType::class, [
                'attr' => ['data-controller' => 'select2'],
                'entry_type' => SymptomType::class,
                'col' => 6
            ])
            ->addModelTransformer($this)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Disease::class,
        ]);
    }

    public function transform($value)
    {
        return $value;
    }

    public function reverseTransform($value)
    {
        $text = preg_replace('/<.*?>/', '', $value->getContent());
        $seconds = strlen($text) / 25;
        $value->setReadingSeconds(round($seconds));
        return $value;
    }
}
