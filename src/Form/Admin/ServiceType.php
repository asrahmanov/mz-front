<?php

namespace App\Form\Admin;

use App\Entity\Service;
use App\Form\Admin\Field\CollectionType;
use App\Form\Admin\Field\ImageType;
use App\Form\Admin\Field\SlugType;
use App\Form\Admin\Field\WysiwygType;
use App\Repository\ServiceRepository;
use phpDocumentor\Reflection\Types\Collection;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ServiceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('slug', SlugType::class, ['target' => '#service_name'])
            ->add('excerpt')
            ->add('image1', ImageType::class, ['label' => 'Изображение для превью', 'width' => '400px', 'height' => '150px'])
            ->add('image2', ImageType::class, ['label' => 'Изображение для страницы', 'width' => '150px', 'height' => '150px'])
            ->add('priceItems', null, [
                'attr' => ['data-controller' => 'select2'],
                'choice_label' => 'getFullName'
            ])
            ->add('priceFrom', null, ['required' => true])
            ->add('content', WysiwygType::class)
            ->add('indications', WysiwygType::class, [
                'options' => [
                    'templates' => [
                        ['title' => 'Две колонки', 'description' => '', 'content' =>
                            '<div class="row"><div class="col"><p>Колонка 1</p></div><div class="col"><p>Колонка 2</p></div></div>'
                        ],
                    ]
                ]
            ])
            ->add('contraindications', WysiwygType::class, [
                'options' => [
                    'body_class' => 'indications__body_red _wysiwyg',
                ]
            ])
            ->add('advantages', CollectionType::class, ['entry_type' => ServiceAdvantagesType::class])
            ->add('doctors', null, ['attr' => ['data-controller' => 'select2']])
            ->add('qAs', null, ['attr' => ['data-controller' => 'select2']])
            ->add('children', EntityType::class, [
                'attr' => ['data-controller' => 'select2'],
                'label' => 'подуслуги',
                'by_reference' => false,
                'class' => Service::class,
                'required' => false,
                'multiple' => true,
                'query_builder' => function (ServiceRepository $repository) use ($options) {
                    $qb = $repository->createQueryBuilder('service');
                    $service = $options['data'];
                    if ($service->getId()) {
                        $ids = [$service->getId()];
                        while ($service = $service->getParent()) {
                            $ids[] = $service->getId();
                        }
                        return $qb->where('service.id NOT IN (:exclude)')
                            ->setParameter('exclude', $ids);
                    }
                    return $qb;
                }
            ])
            ->add('clinics', null, ['attr' => ['data-controller' => 'select2']])
            ->add('reviews', null, [
                'attr' => ['data-controller' => 'select2'],
                'label' => 'Отзывы'
            ])
            ->add('hardwares', null, ['attr' => ['data-controller' => 'select2']])
            ->add('articles', null, ['attr' => ['data-controller' => 'select2']])
            ->add('promos', null, ['attr' => ['data-controller' => 'select2']])
            ->add('showInMainPage')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Service::class,
        ]);
    }
}
