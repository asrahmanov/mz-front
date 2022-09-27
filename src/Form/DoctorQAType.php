<?php

namespace App\Form;

use App\Entity\QA;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Validator\Constraints\Required;

class DoctorQAType extends AbstractType
{
    private $router;

    public function __construct(RouterInterface $router)
    {
        $this->router = $router;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('questionText', TextareaType::class, [
                'label' => 'Ваш вопрос',
                'attr' => [
                    'class' => 'input _req',
                    'data-value' => '...',
                    'autocomplete' => 'off',
                ]])
            ->add('authorName', TextType::class, [
                'label' => 'Имя',
                'attr' => [
                    'class' => 'input input_m _req',
                    'data-value' => 'Иванов Иван',
                    'autocomplete' => 'off',
                ],

            ])
            ->add('authorEmail', TextType::class, [
                'label' => 'E-mail',
                'attr' => [
                    'class' => 'input input_m _req _email',
                    'data-value' => 'yourmail@mail.ru',
                    'autocomplete' => 'off',
                ]
            ])
            ->add('isPublicationAllowed', CheckboxType::class, [
                'label' => 'Разрешить публикацию вопроса и ответа на него на нашем сайте',
                'label_attr' => ['class' => 'checkbox__text'],
                'attr' => [
                    'class' => 'checkbox__input',
                ]
            ])
        ;

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => QA::class,
            'attr' => [
                'class' => 'form-appointment form-appointment_bg-clear ajax',
                'novalidate' => 'novalidate',
            ],
            'action' => $this->router->generate('doctor_q_a_form'),
        ]);
    }
}
