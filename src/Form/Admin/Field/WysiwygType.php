<?php


namespace App\Form\Admin\Field;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;

class WysiwygType extends AbstractType
{
    private $defaultOptions = [
        'content_css' => '/css/style.min.css',
    ];

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefault('attr', [
            'data-controller' => 'wysiwyg',
        ]);
        $resolver->setDefault('options', []);
        $resolver->setDefault('required', false);
    }

    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['attr']['data-wysiwyg-options-value'] = json_encode(array_merge(
            $this->defaultOptions,
            $options['options'],
        ));
    }

    public function getParent()
    {
        return TextareaType::class;
    }
}
