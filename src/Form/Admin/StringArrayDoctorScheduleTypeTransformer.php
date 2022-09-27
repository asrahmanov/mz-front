<?php


namespace App\Form\Admin;


use Symfony\Component\Form\DataTransformerInterface;

class StringArrayDoctorScheduleTypeTransformer implements DataTransformerInterface
{
    public function reverseTransform($value)
    {
        dump(__METHOD__);
        return $value;
    }

    public function transform($value)
    {
        dump(__METHOD__);
        return $value;
    }
}