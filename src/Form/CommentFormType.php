<?php

namespace App\Form;

use App\Entity\Comment;
use App\Entity\Course;
use App\Entity\User;
use Boruta\StarRatingBundle\Form\StarRatingType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CommentFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('content',TextType::class,[
                'label' => 'Comment',
                'attr' => [
                    'placeholder'=>'Add your comment'
                ]
            ] )
            ->add('rating', StarRatingType::class, [
                'label' => 'Rating'
            ]);
/*         ->add('course', EntityType::class, [
                'class' => Course::class,
'choice_label' => 'id',
            ])*/
/*           ->add('user', EntityType::class, [
                'class' => User::class,
'choice_label' => 'id',
            ])*/
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Comment::class,
        ]);
    }
}
