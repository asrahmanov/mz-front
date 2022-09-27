<?php

namespace App\Form;

use App\Entity\DoctorAppointment;
use App\Form\Admin\Field\DateType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Validator\Constraints\Length;

class DoctorAppointment2Type extends AbstractType
{
    private RouterInterface $router;

    /**
     * DoctorAppointment2Type constructor.
     * @param RouterInterface $router
     */
    public function __construct(RouterInterface $router)
    {
        $this->router = $router;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('date', DateType::class)
            ->add('patientName')
            ->add('patientTel')
            ->add('doctor')
            ->add('clinic')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'allow_extra_fields' => true,
            'data_class' => DoctorAppointment::class,
            'action' => $this->router->generate('appointment2_form'),
            'attr' => [
                'class' => 'form-appointment form-appointment_bg-clear',
            ]
        ]);
    }
}
