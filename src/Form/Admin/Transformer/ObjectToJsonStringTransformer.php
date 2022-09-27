<?php

namespace App\Form\Admin\Transformer;

use Symfony\Component\Form\DataTransformerInterface;

class ObjectToJsonStringTransformer implements DataTransformerInterface
{
    public function transform($value)
    {
        return json_encode($value);
    }

    public function reverseTransform($value)
    {
        return $value ? json_decode($value) : json_encode([]);
    }
}
