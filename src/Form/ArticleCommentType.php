<?php

namespace App\Form;

use App\Entity\Article;
use App\Entity\ArticleComment;
use App\Form\Admin\ArticleType;
use App\Form\Field\HiddenEntityType;
use Doctrine\ORM\Mapping\Entity;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Routing\RouterInterface;

class ArticleCommentType extends AbstractType
{
    protected RouterInterface $router;

    public function __construct(RouterInterface $router)
    {
        $this->router = $router;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('authorName')
            ->add('authorTel')
            ->add('text')
            ->add('article', HiddenEntityType::class, ['class' => Article::class])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ArticleComment::class,
            'action' => $this->router->generate('article_comment_form')
        ]);
    }
}
