<?php

namespace App\Form\Admin;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserType extends AbstractType implements DataTransformerInterface
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username')
            ->add('roles', ChoiceType::class, [
                'choices' => [
                    'Администратор' => 'ROLE_ADMIN',
                    'Пользователь' => 'ROLE_USER',
                ],
                'multiple' => true,
                'attr' => ['data-controller' => 'select2'],
            ])
            ->add('password', PasswordType::class, ['attr' => ['autocomplete' => 'new-password']]);

        $builder->addModelTransformer($this);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }

    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['attr']['autocomplete'] = 'off';
    }

    public function transform($value)
    {
        return $value;
    }

    public function reverseTransform($value)
    {
        $encodedPassword = $this->encoder->encodePassword($value, $value->getPassword());
        $value->setpassword($encodedPassword);
        return $value;
    }
}
