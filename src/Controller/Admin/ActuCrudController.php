<?php

namespace App\Controller\Admin;

use App\Entity\Actu;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use phpDocumentor\Reflection\Types\Boolean;
use Symfony\Component\String\Slugger\SluggerInterface;

class ActuCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Actu::class;
    }
    public function createEntity(string $entityFqcn) : Actu
    {
        $entity = parent::createEntity($entityFqcn);
        $entity->setCreatedAt(new \DateTimeImmutable());
        $entity->setUpdatedAt(new \DateTimeImmutable());
        $entity->setPublished(true);
        /*  $entity->setSlug($this->slugger->slug($entity->getName()));*/

        return $entity;
    }
    public function updateEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        // Before edit entity on db
        $entityInstance->setUpdatedAt(new \DateTimeImmutable());
        parent::updateEntity($entityManager, $entityInstance);
        // After edit entity on db
    }


    public function configureFields(string $pageName): iterable
    {

        yield IdField::new('id')
            ->onlyOnIndex();
        yield TextField::new('name');
        yield TextEditorField::new('content');
        yield BooleanField::new('published')
        ->onlyOnIndex();
        yield SlugField::new('slug')
            ->setTargetFieldName('name')
        ;
        yield ImageField::new('image')
            ->setBasePath('images/actus')
            ->setUploadDir('assets/images/actus')
            ->setUploadedFileNamePattern('[contenthash].[extension]')
            ->setRequired($pageName === Crud::PAGE_NEW);

        yield DateField::new('publishedAt')
        ;
        yield DateField::new('createdAt')
            ->onlyOnIndex();
        yield DateField::new('updatedAt')
            ->onlyOnIndex();
        yield AssociationField::new('family' );

    }

}
