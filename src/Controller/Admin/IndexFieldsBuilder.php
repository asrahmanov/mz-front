<?php


namespace App\Controller\Admin;

class IndexFieldsBuilder
{
    protected $fieldsArray = [];

    public function add(string $name, string $label, string $property = null)
    {
        $field = [];
        $field['name'] = $name;
        $field['label'] = $label;
        if ($property) {
            $field['property'] = $property;
        }
        $this->fieldsArray[] = $field;
        return $this;
    }

    /**
     * @return array
     */
    public function getFieldsArray(): array
    {
        return $this->fieldsArray;
    }
}
