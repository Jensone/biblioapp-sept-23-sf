<?php

namespace App\Form;

use App\Entity\Book;
use App\Entity\Author;
use App\Entity\Editor;
use App\Entity\Format;
use App\Entity\Category;
use App\Entity\Language;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class BookType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Titre du livre',
                'attr' => [
                    'class' => 'form-control'
                ],
            ])
            ->add('year', NumberType::class, [
                'label' => 'Année de sortie',
                'attr' => [
                    'class' => 'form-control'
                ],
            ])
            ->add('isbn', TextType::class, [
                'label' => 'ISBN',
                'attr' => [
                    'class' => 'form-control'
                ],
            ])
            ->add('price', MoneyType::class, [
                'label' => 'Valeur du livre',
                'attr' => [
                    'class' => 'form-control'
                ],
            ])
            ->add('pages', NumberType::class, [
                'label' => 'Nombre de pages',
                'attr' => [
                    'class' => 'form-control'
                ],
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Résumé du livre',
                'attr' => [
                    'class' => 'form-control'
                ],
            ])
            ->add('slug', TextType::class, [
                'label' => 'slug',
                'attr' => [
                    'class' => 'form-control'
                ],
            ])
            ->add('cover', TextType::class, [
                'label' => 'Page de couverture',
                'attr' => [
                    'class' => 'form-control'
                ],
            ])
            ->add('isAvailable', CheckboxType::class, [
                'label' => 'Disponiblité',
                'attr' => [
                    'class' => 'form-check'
                ],
            ])
            ->add('category', EntityType::class, [
                'class' => Category::class, // class de l'entité
                'choice_label' => 'name',
                'label' => 'Catégorie du livre',
                'attr' => [
                    'class' => 'form-control' // class css
                ],
            ])
            ->add('authors', EntityType::class, [
                'class' => Author::class,
                'choice_label' => 'firstname',
                'multiple' => true,
                'label' => 'Auteur(s) du livre',
                'attr' => [
                    'class' => 'form-control'
                ],
            ])
            ->add('format', EntityType::class, [
                'class' => Format::class,
                'choice_label' => 'name',
                'label' => 'Format du livre',
                'attr' => [
                    'class' => 'form-control'
                ],
            ])
            ->add('editor', EntityType::class, [
                'class' => Editor::class,
                'choice_label' => 'name',
                'label' => 'Éditeur',
                'attr' => [
                    'class' => 'form-control'
                ],
            ])
            ->add('language', EntityType::class, [
                'class' => Language::class,
                'choice_label' => 'name',
                'label' => 'Langue',
                'attr' => [
                    'class' => 'form-control'
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Book::class,
        ]);
    }
}
