<?php

namespace App\Controller\Admin;

use App\Entity\Book;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class BookCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Book::class;
    }
    
    public function configureActions(Actions $actions): Actions
    {
        return parent::configureActions($actions)
            ->add(Crud::PAGE_INDEX, Action::DETAIL)
            ;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            FormField::addPanel('Titre du livre')
                ->setIcon('fas fa-book')
                ->setHelp('Saisissez le titre du livre'),
                TextField::new('title', 'Titre du livre'),

            SlugField::new('slug')
                ->setTargetFieldName('title')
                ->hideOnIndex(),

            FormField::addPanel('Année de publication')
                ->setIcon('fas fa-calendar')
                ->setHelp('Quelle est l\'année de publication du livre ?'),
                TextField::new('year','Année de publication'),

            FormField::addPanel('ISBN')
                ->setIcon('fas fa-barcode')
                ->setHelp('Quelle est l\'ISBN du livre ? \n L\'ISBN est un numéro international normalisé du livre. \n Il est composé comme suit : 978-2-1234-5680-3'),
                TextField::new('isbn','ISBN'),

            FormField::addPanel('Valeur du livre')
                ->setIcon('fas fa-euro-sign')
                ->setHelp('Quelle est la valeur du livre ?'),
                NumberField::new('price','Valeur du livre en euros'),

            FormField::addPanel('Nombre de pages')
                ->setIcon('fas fa-file')
                ->setHelp('Combien de pages contient le livre ?'),
                NumberField::new('pages','Nombre de pages'),

            FormField::addPanel('Description du livre')
                ->setIcon('fas fa-file-alt')
                ->setHelp('Saissisez la description ou résumé du livre'),
                TextEditorField::new('description','Description du livre'),

            // Upload de l'image de couverture du livre
            FormField::addPanel('Couverture du livre')
                ->setIcon('fas fa-image')
                ->setHelp('Ajoutez une image de couverture du livre'),
                ImageField::new('cover','Couverture du livre')
                    ->setBasePath('uploads/images/')
                    ->setUploadDir('public/uploads/images/')
                    ->setUploadedFileNamePattern('[slug]-[timestamp].[extension]')
                ,

            FormField::addPanel('Disponibilité du livre')
                ->setIcon('fas fa-check')
                ->setHelp('Ce livre est-il disponible à l\'emprunt ?'),
                BooleanField::new('isAvailable','Disponibilité du livre'),

        ];
        
        // Slug (pas besoin)
        // Cover (mise en place d'un upload)
    }
}
