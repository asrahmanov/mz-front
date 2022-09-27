<?php

namespace App\Form\Field;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EntityRadioType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'expanded' => 'true',
        ]);
    }

    public function getParent()
    {
        return EntityType::class;
    }
}
