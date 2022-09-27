<?php

namespace App\Form\Field;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class HiddenEntityType extends AbstractType implements DataTransformerInterface
{
    protected $em;
    protected $entityType;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setRequired('class');
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $this->entityType = $options['class'];
        $builder->addModelTransformer($this);
    }

    public function getParent()
    {
        return HiddenType::class;
    }

    public function transform($value)
    {
        if (! $value) {
            return '';
        }

        return $value->getId();
    }

    public function reverseTransform($value)
    {
        if (! $value) {
            return null;
        }

        return $this->em->getRepository($this->entityType)->find($value);
    }
}
