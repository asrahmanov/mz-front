<?php


namespace App\Form\Admin\Field;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ImageType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'required' => false,
            'width' => '100%',
            'height' => '100%',
        ]);
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('url', HiddenType::class)
            ->add('name')
        ;
    }

    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['width'] = $options['width'];
        $view->vars['height'] = $options['height'];
    }
}
