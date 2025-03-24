<?php

namespace App\Form;

use App\Entity\Mailing;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MailingType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'Your  name',
                    ]

                ,
            ])
            ->add('email',EmailType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'Your email',]

                ,
            ])
            ->add('submit', SubmitType::class,[
                'label' => 'Subscribe',
                'attr' => [
                    'placeholder' => 'Your email',
                    'class' => 'btn-warning']

                ,
            ])

        ;

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Mailing::class,
        ]);
    }
}
