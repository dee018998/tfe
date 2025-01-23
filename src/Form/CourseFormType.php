<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Color;
use App\Entity\Course;
use App\Entity\Level;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\NotBlank;
use Vich\UploaderBundle\Form\Type\VichFileType;
use Vich\UploaderBundle\Form\Type\VichImageType;

class CourseFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('smallDescription')
            ->add('fullDescription')
            ->add('duration')
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
            ->add('alt')
            ->add('pdfFile', VichFileType::class, [
                'label' => 'Programme en pdf',
                'required' => false,
                'allow_delete' => false,
                'download_uri' => false,
                'asset_helper' => true,
                'constraints' => $options['is_new'] ? [
                    new NotBlank([
                        'message' => "le pdf est requise",
                    ])
                ] : [],
            ])
           /* ->add('programFile', FileType::class, [
                'label' => "Télécharger l'horraire (PDF file)",

                // unmapped means that this field is not associated to any entity property
                'mapped' => false,

                // make it optional so you don't have to re-upload the PDF file
                // every time you edit the Product details
                'required' => true,

                // unmapped fields can't define their validation using attributes
                // in the associated entity, so you can use the PHP constraint classes
                'constraints' => [
                    new File([
                        'maxSize' => '1024k',
                        'mimeTypes' => [
                            'application/pdf',
                            'application/x-pdf',
                        ],
                        'mimeTypesMessage' => 'Please upload a valid PDF document',
                    ])
                ],
            ])*/
            // ...


           /* ->add('program')*/
            ->add('price')
            ->add('category', EntityType::class, [
                'class' => Category::class,
                'choice_label' => 'name',
                'placeholder' => 'Choose a category'
            ])
            ->add('level', EntityType::class, [
                'class' => Level::class,
                'choice_label' => 'name',
                'placeholder' => 'Choose a level'
            ])
            ->add('color', EntityType::class, [
                'class' => Color::class,
                'choice_label' => 'name',
                'placeholder' => 'Choose a color'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Course::class,
            'is_new' => false
        ]);
    }
}
