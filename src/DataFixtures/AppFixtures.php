<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Book;
use App\Entity\User;
use App\Entity\Order;
use App\Entity\Author;
use App\Entity\Client;
use App\Entity\Editor;
use App\Entity\Format;
use App\Entity\Category;
use App\Entity\Language;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // On instancie Faker pour générer des données aléatoires en français
        $faker = Factory::create($fakerLocale = 'fr_FR');

        $user = new User();
        $user->setEmail('hello@martin.fr')
            ->setPassword('$2y$13$tbtgE82nEIciQHnsb7pu5.NCzLo8przS6w8aWvgEJxNC9xCRKOx02')
            ->setRoles(['ROLE_ADMIN'])
            ;
        $manager->persist($user);

        /**
         * Les catégories
         * Traitement pour l'ajout des catégories
         */
        $categories = [
            'Roman',
            'Bande dessiné',
            'Poésie',
            'Fantastique',
            'Documentaire',
            'Policier',
            'Aventure',
            'Biographie',
        ];
        // Les ojects catégories instanciés
        $objectCategory = [];
        // On boucle sur les catégories
        for ($i = 0; $i < count($categories); $i++) {
            $category = new Category;
            $category->setName($categories[$i])
                ->setDescription($faker->sentence(1))
                ->setImage($faker->image());
            // On ajoute l'objet catégorie dans le tableau
            array_push($objectCategory, $category);
            // On persiste l'objet catégorie
            $manager->persist($category);
        }

        /**
         * Les auteurs
         * Traitement pour l'ajout des auteurs
         */
        $objectAuthor = [];
        // Les auteurs
        for ($i = 0; $i < 100; $i++) {
            $author = new Author();
            $author->setFirstname($faker->firstName())
                ->setLastname($faker->lastName())
                ->setBio($faker->sentence(1))
                ->setLink($faker->url());
            // On ajout l'objet auteur dans le tableau
            array_push($objectAuthor, $author);
            // On persiste l'objet auteur
            $manager->persist($author);
        }

        /**
         * Les éditeurs
         * Traitement pour l'ajout des éditeurs
         */
        $editors = [
            'Gallimard',
            'Hachette',
            'Larousse',
            'Nathan',
            'Hatier',
            'Flammarion',
            'Dunod',
            'Livre de poche',
        ];
        // Les objects éditeurs instanciés
        $objectEditor = [];
        // On boucle sur les éditeurs
        for ($i = 0; $i < count($editors); $i++) {
            $editor = new Editor();
            $editor->setName($editors[$i])
                ->setYear($faker->numberBetween(1950, 2023));
            // On ajoute l'objet éditeur dans le tableau
            array_push($objectEditor, $editor);
            // On persiste l'objet éditeur
            $manager->persist($editor);
        }

        /**
         * Les formats
         * Traitement pour l'ajout des formats
         */
        $formats = [
            'Poche',
            'Broché',
            'Relié',
        ];

        // Les objects formats instanciés
        $objectFormat = [];
        // On boucle sur les formats
        for ($i = 0; $i < count($formats); $i++) {
            $format = new Format();
            $format->setName($formats[$i]);
            // On ajoute l'objet format dans le tableau
            array_push($objectFormat, $format);
            // On persiste l'objet format
            $manager->persist($format);
        }

        /**
         * Les langues
         * Traitement pour l'ajout des langues
         */
        $languages = [
            [
                'Français',
                'https://upload.wikimedia.org/wikipedia/commons/thumb/c/c3/Flag_of_France.svg/1200px-Flag_of_France.svg.png'
            ],
            [
                'Anglais',
                'https://upload.wikimedia.org/wikipedia/commons/thumb/a/ae/Flag_of_the_United_Kingdom.svg/1200px-Flag_of_the_United_Kingdom.svg.png'
            ],
            [
                'Espagnol',
                'https://upload.wikimedia.org/wikipedia/commons/thumb/9/9a/Flag_of_Spain.svg/1200px-Flag_of_Spain.svg.png'
            ],
            [
                'Allemand',
                'https://upload.wikimedia.org/wikipedia/commons/thumb/b/ba/Flag_of_Germany.svg/1200px-Flag_of_Germany.svg.png'
            ],
            [
                'Italien',
                'https://upload.wikimedia.org/wikipedia/commons/thumb/0/03/Flag_of_Italy.svg/1200px-Flag_of_Italy.svg.png'
            ],
            [
                'Portugais',
                'https://upload.wikimedia.org/wikipedia/commons/thumb/5/5c/Flag_of_Portugal.svg/1200px-Flag_of_Portugal.svg.png'
            ],
            [
                'Russe',
                'https://upload.wikimedia.org/wikipedia/commons/thumb/f/f3/Flag_of_Russia.svg/1200px-Flag_of_Russia.svg.png'
            ],
            [
                'Chinois',
                'https://upload.wikimedia.org/wikipedia/commons/thumb/f/fa/Flag_of_the_People%27s_Republic_of_China.svg/1200px-Flag_of_the_People%27s_Republic_of_China.svg.png'
            ],
        ];
        // Les objects langues instanciés
        $objectLanguage = [];
        // On boucle sur les langues
        for ($i = 0; $i < count($languages); $i++) {
            $language = new Language();
            $language->setName($languages[$i][0])
                ->setFlag($languages[$i][1]);
            // On ajoute l'objet langue dans le tableau
            array_push($objectLanguage, $language);
            // On persiste l'objet langue
            $manager->persist($language);
        }

        /**
         * Les livres
         * Traitement pour l'ajout des livres
         */
        $objectBook = [];
        $objectClient = [];
        for ($i = 0; $i < 50; $i++) {
            $book = new Book();
            $book->setTitle($faker->sentence(2)) // 2 mots
                ->setDescription($faker->sentence(10)) // 7 mots
                ->setSlug($faker->slug()) // Ajout d'un slug aléatoire
                ->setPages($faker->numberBetween(50, 500)) // 50 à 500
                ->setYear($faker->numberBetween(1950, 2023)) // 1950 à 2023
                ->setCategory($objectCategory[rand(0, 7)]) // Ajout d'une catégorie aléatoire
                ->addAuthor($objectAuthor[rand(0, 99)]) // Ajout d'un auteur aléatoire
                ->setEditor($objectEditor[rand(0, 7)]) // Ajout d'un éditeur aléatoire
                ->setFormat($objectFormat[rand(0, 2)]) // Ajout d'un format aléatoire
                ->setLanguage($objectLanguage[rand(0, 7)]) // Ajout d'une langue aléatoire
                ->setCover($faker->image()) // Ajout d'une image aléatoire
                ->setPrice($faker->randomFloat(2, 5, 30)) // Prix entre 5 et 30 avec 2 chiffres après la virgule
                ->setIsbn($faker->isbn13()) // Ajout d'un isbn aléatoire
                ->setIsAvailable($faker->boolean()) // Ajout d'un booléen aléatoire
            ;

            // On ajoute 20 objets livre dans le tableau
            if ($i < 20) {
                array_push($objectBook, $book);
            }

            // On ajoute 40 clients aléatoirement qui ont emprunté le livre
            if ($i < 20) {
                $client = new Client();
                $client->setFirstname($faker->firstName())
                    ->setLastname($faker->lastName())
                    ->setEmail($faker->email())
                    ->setPostalCode(95130)
                    ->setCity('Franconville')
                    ->setYear($faker->numberBetween(1950, 2023))
                    ->addBook($book)
                    ->setDeposit($faker->boolean());

                // On ajoute l'objet client dans le tableau
                array_push($objectClient, $client);
                // On persiste l'objet client
                $manager->persist($client);
            }
            // On persiste l'objet livre
            $manager->persist($book);
        }

        /**
         * Les commandes
         * Traitement pour l'ajout des commandes
         */
        for ($i = 0; $i < 10; $i++) {
            $order = new Order();
            $order->setBuyer($user) // Ajout d'un client aléatoire
                ->setDateStart($faker->dateTimeBetween('-6 months', 'now')) // Ajout d'une date aléatoire
                ->setDateEnd($faker->dateTimeBetween('now', '+6 months')) // Ajout d'une date aléatoire
                ->setStatut($faker->boolean()) // Ajout d'un booléen aléatoire
                ->addBook($objectBook[rand(0, 10)]) // Ajout d'un livre aléatoire
                ->setTotal(25.00)
                ;

                if ($i < 7){
                    $order->addBook($objectBook[rand(11, 19)]); // Ajout d'un second livre aléatoire
                }

            // On persiste l'objet commande
            $manager->persist($order);
        }

        // On envoie les données en BDD
        $manager->flush();
    }
}
