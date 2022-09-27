<?php


namespace App\Form\Admin\Field;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\ChoiceList\ChoiceList;
use Symfony\Component\Form\ChoiceList\Loader\CallbackChoiceLoader;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;

class JSTableType extends AbstractType implements DataTransformerInterface
{
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefault('attr', ['data-controller'=>'js-table']);
        $resolver->setDefault('compound', false);
        $resolver->setDefault('required', false);
        $resolver->setDefault('options', []);
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->addViewTransformer($this);
    }

    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['attr']['data-js-table-options-value'] = json_encode($options['options']);
    }

    public function transform($data)
    {
        return $data ? json_encode($data) : json_encode([]) ;
    }

    public function reverseTransform($data)
    {
        $data = $data ? json_decode($data) : [];
        return $this->removeEmptyRows($data);
    }

    function removeEmptyRows($arr) {
        $result = [];
        foreach ($arr as $row) {
            $isEmpty = true;
            foreach ($row as $cell) {
                if ($cell) {
                    $isEmpty = false;
                    break;
                }
            }
            if (!$isEmpty) $result[] = $row;
        }
        return $result;
    }
}
