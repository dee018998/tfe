<?php

namespace App\Form;

use app\DTO\MailDTO;
use App\Entity\User;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MailUserFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder

        /*       ->add('user', CollectionType::class, [
                   // each entry in the array will be an "email" field
                   'entry_type' => EmailType::class,
                   // these options are passed to each "email" type
                   'entry_options' => [
                       'attr' => ['class' => 'email'],
                   ],
               ])*/
        /*  'entry_options' => [
              'attr' => ['class' => 'email-box'],
          ],*/
        /*            ->add('user', EntityType::class, [
                        'class' => User::class,
                        'query_builder' => function (EntityRepository $er): QueryBuilder {
                            return $er->createQueryBuilder('u')
                                ->orderBy('u.roles', 'ASC');
                        },
                        'label' => 'Choisir un destinataire',
                       'choice_label' => 'email'
                    ])*/
/*->add('user', ChoiceType::class, [
    'choices'  => [
        'Maybe' => null,
        'Yes' => true,
        'No' => false,
    ],
])*/
        ->add('subject', TextType::class, [
            'label' => 'Votre sujet',
        ])
        ->add('message', TextareaType::class,)
        ->add('submit', SubmitType::class,)

    ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => MailDTO::class,
        ]);
    }
}
