<?php


namespace App\Form\Admin;


use App\Entity\DoctorScheduleDate;
use App\Form\Admin\Field\DatePickerType;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\FormBuilderInterface;

class DoctorScheduleDatesType extends DatePickerType implements DataTransformerInterface
{
    const DATE_FORMAT = 'd.m.Y';
    const SEPARATOR = ', ';

    public function getParent()
    {
        return DatePickerType::class;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->addViewTransformer($this);
    }

    public function transform($value)
    {
        if (! $value) {
            return null;
        }

        $result = '';
        foreach ($value as $item) {
            if ($result) {
                $result = implode(self::SEPARATOR, [$result, $item->getDate()->format(self::DATE_FORMAT)]);
            }
            else {
                $result = $item->getDate()->format(self::DATE_FORMAT);
            }
        }
        return $result;
    }

    public function reverseTransform($value)
    {
        if (! $value) {
            return [];
        }

        $result = [];

        foreach (explode(self::SEPARATOR, $value) as $item) {
            $result[] = (new DoctorScheduleDate())->setDate(\DateTime::createFromFormat(self::DATE_FORMAT, $item));
        }

        return $result;
    }
}