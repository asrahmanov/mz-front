<?php

namespace App\Exception;

use Symfony\Component\Form\FormErrorIterator;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Validator\ConstraintViolationListInterface;

class ValidationFailedException extends AppException
{
    private FormInterface $form;

    public function __construct(FormInterface $form)
    {
        $this->form = $form;
        parent::__construct();
    }

    public function getFormErrors(): array
    {
        return $this->getErrorsFromForm($this->form);
    }

    private function getErrorsFromForm(FormInterface $form)
    {
        $errors = [];
        foreach ($form->getErrors() as $error) {
            $errors[] = $error->getMessage();
        }
        foreach ($form->all() as $childForm) {
            if ($childForm instanceof FormInterface) {
                if ($childErrors = $this->getErrorsFromForm($childForm)) {
                    $errors[$childForm->getName()] = $childErrors;
                }
            }
        }
        return $errors;
    }
}
