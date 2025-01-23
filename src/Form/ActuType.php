<?php

namespace App\Form;

use App\Entity\Actu;
use App\Entity\Family;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ActuType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('createdAt', null, [
                'widget' => 'single_text'
            ])
            ->add('content')
            ->add('slug')
            ->add('image')
            ->add('updatedAt', null, [
                'widget' => 'single_text'
            ])
            ->add('isPublished')
            ->add('publishedAt', null, [
                'widget' => 'single_text'
            ])
            ->add('family', EntityType::class, [
                'class' => Family::class,
'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Actu::class,
        ]);
    }
}
