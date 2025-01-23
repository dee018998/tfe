<?php

namespace App\Form;

use App\Entity\Actu;
use App\Entity\Family;
use Symfony\Component\Form\AbstractType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Vich\UploaderBundle\Form\Type\VichImageType;

class ActuFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name',TextType::class,[
                'label'=>'Titre'
            ])
            ->add('content',TextareaType::class,[
            'label' => 'Contenu',
            ])
         /*   ->add('slug')*/
         ->add('imageFile', VichImageType::class, [
             'label' => 'Image',
             'required' => false,
             'allow_delete' => false,
             'download_uri' => false,
             'image_uri' => false,
             'asset_helper' => true,
             'constraints' => $options['is_new'] ? [
                 new NotBlank([
                     'message' => "l'image est requise",
                    ])
                ] : [],
            ])
            ->add('family', EntityType::class, [
                'class' => Family::class,
                'choice_label' => 'name',
                'placeholder' => 'Choose a family'
            ]);

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Actu::class,
            'is_new' => false
        ]);
    }
}
