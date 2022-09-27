<?php

namespace App\Form;

use App\Entity\Clinic;
use App\Entity\Specialty;
use App\Form\Field\CustomCheckboxType;
use App\Form\Field\EntityRadioType;
use App\Repository\DoctorRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DoctorSearchType extends AbstractType
{
    private DoctorRepository $doctorRepository;

    /**
     * @param DoctorRepository $doctorRepository
     */
    public function __construct(DoctorRepository $doctorRepository)
    {
        $this->doctorRepository = $doctorRepository;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, ['required' => false])
            ->add('speciality', EntityType::class, [
                'class' => Specialty::class,
                'required' => false,
            ])
            ->add('category', ChoiceType::class, [
                'choices' => $this->doctorRepository->getCategories(),
                'required' => false,
                'choice_label' => function ($value) {
                    return $value;
                }
            ])
            ->add('clinic', EntityRadioType::class, [
                'class' => Clinic::class,
                'required' => false,
                'placeholder' => 'Все клиники',
            ])
            ->add('onlineConsultation', CustomCheckboxType::class, ['label' => 'Онлайн-консультация'])
            ->add('today', CustomCheckboxType::class, ['label' => 'Принимает сегодня'])
            ->add('promo', CustomCheckboxType::class, [
                'label' => 'АКЦИЯ',
                'label_attr' => [
                    'class' => 'color-red',
                ]])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'allow_extra_fields' => true,
            ''
        ]);
    }
}
