<?php


namespace App\Form\Admin\Field;


use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PageBlockType extends AbstractType
{
    protected $parameterBag;
    public function __construct(ParameterBagInterface $parameterBag)
    {
        $this->parameterBag = $parameterBag;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefault('page_block_types', []);
        $resolver->setDefault('compound', false);
    }

    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['page_block_types'] = $this->parameterBag->get('page_block_types');
    }
}
