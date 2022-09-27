<?php

namespace App\Form\Admin;

use App\Entity\Doctor;
use App\Form\Admin\Field\CropperType;
use App\Form\Admin\Field\EditorJsType;
use App\Form\Admin\Field\ImageType;
use App\Form\Admin\Field\JSTableType;
use App\Form\Admin\Field\SlugType;
use App\Form\Admin\Field\TestType;
use App\Form\Admin\Field\WysiwygType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use App\Form\Admin\Field\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Validator\Constraints\NotBlank;

class DoctorType extends AbstractType
{
    private $router;


    public function __construct(UrlGeneratorInterface $router)
    {
        $this->router = $router;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('isEnabled')
            ->add('firstname', null, ['constraints' => [new NotBlank()]])
            ->add('lastname', null, ['constraints' => [new NotBlank()]])
            ->add('middlename')
            ->add('slug', SlugType::class, [
                'target' => '#doctor_lastname',
                'constraints' => [new NotBlank()]
            ])
            ->add('photo', ImageType::class, ['width' => '150px', 'height' => '150px'])
            ->add('gallery', CollectionType::class, [
                'entry_type' => ImageType::class,
                'col' => 'auto',
                'entry_options' => [
                    'width' => '150px',
                    'height' => '150px'
                ]])
            ->add('appointment', null, [
                'attr' => ['data-controller' => 'select2'],
                'label' => 'Услуга первичного приёма',
                'help_html' => true,
                'help' => sprintf('Заполняется в разделе <a href="%s">Цен</a>', $this->router->generate('admin.price_item')),
                'choice_label' => 'fullName'
            ])
            ->add('category')
            ->add('leadingSpecialist')
            ->add('specialties', null, [
                'attr' => ['data-controller' => 'select2'],
                'required' => false,
            ])
            ->add('post')
            ->add('experience')
            ->add('excerpt')
            ->add('video', null, [
                'help_html' => true,
                'help' => 'Код видеоролика Youtube. Можно скопировать из адресной строки https://www.youtube.com/watch?v=<u class="text-red">_78iF6_EK6I</u>',
            ])
            ->add('promo')
            ->add('onlineConsultation')
            ->add('education', JSTableType::class, ['options' => [
                'colHeaders' => ['Год', 'Учреждение', 'Специальность'],
                'columns' => [
                    [
                        'data' => 'year',
                        'type' => 'text',
                    ],
                    [
                        'data' => 'institution',
                        'type' => 'text',
                    ],
                    [
                        'data' => 'specialization',
                        'type' => 'text',
                    ],
                ],
            ]])
            ->add('additionalEducation', JSTableType::class, ['options' => [
                'colHeaders' => ['Год', 'Учреждение', 'Специальность'],
                'columns' => [
                    [
                        'data' => 'year',
                        'type' => 'text',
                    ],
                    [
                        'data' => 'institution',
                        'type' => 'text',
                    ],
                    [
                        'data' => 'specialization',
                        'type' => 'text',
                    ],
                ],
            ]])
            ->add('achievements', CollectionType::class, [
                'entry_type' => DoctorAchievementsType::class,
            ])
            ->add('certs', CollectionType::class, [
                'by_reference' => false,
                'entry_type' => CertType::class,
                'col' => 3
            ])
            ->add('clinics', null, [
                'attr' => ['data-controller' => 'select2'],
                'required' => false,
            ])
            ->add('priceItems', null, [
                    'required' => false, 'label' => 'Стоимость услуг',
                    'attr' => ['data-controller' => 'select2'],
            ])
            ->add('rating1', DoctorRatingType::class, [
                'label' => '<b>Рейтинг для карточки</b>',
                'help' => 'Будет отображаться в списках и т.п.',
                'label_html' => true,
                'attr' => ['class' => 'row align-items-baseline']
            ])
            ->add('rating2', DoctorRatingType::class, [
                'label' => '<b>Рейтинг для страницы</b>',
                'help' => 'Будет отображаться на странице врача',
                'label_html' => true,
                'attr' => ['class' => 'row align-items-baseline']
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Doctor::class,
            'attr' => ['novalidate' => 'novalidate'],
        ]);
    }
}
