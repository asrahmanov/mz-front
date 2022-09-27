<?php

namespace App\Form\Admin;

use App\Entity\Article;
use App\Form\Admin\Field\DatePickerType;
use App\Form\Admin\Field\ImageType;
use App\Form\Admin\Field\JSTableType;
use App\Form\Admin\Field\SlugType;
use App\Form\Admin\Field\WysiwygType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArticleType extends AbstractType implements DataTransformerInterface
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('slug', SlugType::class, ['target' => '#article_name'])
            ->add('image', ImageType::class, ['width' => '150px', 'height' => '150px'])
            ->add('excerpt')
            ->add('createdAt' , DatePickerType::class)
            ->add('checkedAt', DatePickerType::class)
            ->add('updatedAt', DatePickerType::class)
            ->add('content', WysiwygType::class)
            ->add('sources', JSTableType::class, ['options' => [
                'colHeaders' => ['Название', 'Ссылка'],
                'columns' => [
                    ['data' => 'name'],
                    ['data' => 'link'],
                ]
            ]])
            ->add('author', null, ['attr' => ['data-controller' => 'select2']])
            ->add('editor', null, ['attr' => ['data-controller' => 'select2']])
            ->add('expert', null, ['attr' => ['data-controller' => 'select2']])
            ->add('tags', null, ['attr' => ['data-controller' => 'select2']])
            ->add('otherArticles', null, ['attr' => ['data-controller' => 'select2']])
            ->add('votesCount', NumberType::class, [
                'html5' => true,
                'attr' => [
                    'min' => 0
                ],
                'required' => false,
            ])
            ->add('rating', NumberType::class, [
                'html5' => true,
                'attr' => [
                    'step' =>0.1,
                    'min' => 0,
                    'max' => 5
                ],
                'required' => false,
            ])
            ->add('isPopular')
        ;
        $builder->addModelTransformer($this);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
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
