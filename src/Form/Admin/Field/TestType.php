<?php


namespace App\Form\Admin\Field;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TestType extends AbstractType implements DataTransformerInterface
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->addViewTransformer($this);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefault('compound', false);
        $resolver->setDefault('required', false);
    }

    public function transform($data)
    {
        return $data ? json_encode($data) : json_encode([[]]) ;
    }

    public function reverseTransform($data)
    {
        $data = $data ? json_decode($data) : [];
        return $this->removeEmptyRows($data);
    }

    protected function removeEmptyRows($arr) {
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
