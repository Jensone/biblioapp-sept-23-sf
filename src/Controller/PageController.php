<?php

namespace App\Controller;

use App\Form\ContactType;
use App\Repository\BookRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PageController extends AbstractController
{
    #[Route('/', name: 'app_page')]
    public function index(BookRepository $books): Response
    {
        return $this->render('page/index.html.twig', [
            'controller_name' => 'Page',
            'books' => $books->findBy(
                [], // WHERE
                ['year' => 'DESC'], // Ordonner par
                10 // Limiter à
            ),
        ]);
    }

    #[Route('/contact', name: 'app_contact', methods: ['GET', 'POST'])]
    public function contact(
        ContactType $form
        ): Response
    {
        $form = $this->createForm(ContactType::class);

        // On reception les données du formulaire avec Request

        // Si le form est soumis et valide alors

        // On récuprère les données du formulaire pour les mettre dans le mail

        // On instancie un nouveau mail

        // On paramètre le mail

        // On envoie le mail

        // On affiche un message de confirmation





        return $this->render('page/contact.html.twig', [
            'contact' => $form,
        ]);
    }
}
