<?php

namespace App\Form\Admin;

use App\Entity\ClinicRating;
use App\Entity\DoctorRating;
use App\Entity\ReviewSource;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Range;

class DoctorRatingType extends AbstractType
{
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('value', NumberType::class, [
                'required' => true,
                'constraints' => [new NotBlank(), new Range(['min' => 1, 'max' => 5])],
                'html5' => true,
                'row_attr' => [
                    'class' => 'col',
                ],
                'attr' => [
                    'min' => 1,
                    'max' => 5,
                    'step' => 0.1,
                ]
            ])
            ->add('source', null, [
                'attr' => ['data-controller' => 'select2'],
                'required' => true,
                'row_attr' => [
                    'class' => 'col'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => DoctorRating::class,
        ]);
    }

    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        if ($view->vars['value'] === null) {
            $form->get('value')->setData(5);
        }
    }
}
