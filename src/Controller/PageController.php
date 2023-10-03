<?php

namespace App\Controller;

use App\Form\ContactType;
use App\Repository\BookRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

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
        ContactType $form,
        Request $request,
        MailerInterface $mailer
        ): Response
    {
        $form = $this->createForm(ContactType::class);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $name = $form->get('name')->getData();
            $email = $form->get('email')->getData();
            $subject = $form->get('subject')->getData();
            $message = $form->get('message')->getData();
            
            // On paramètre le mail
            $mail = (new Email())
                ->from($email)
                ->to('contact@biblioapp.fr')
                ->priority(Email::PRIORITY_HIGH)
                ->subject($subject)
                ->html(
                    '<div>Vous avez reçu le message suivant de ' . $name . '. <br> Contenu :<br>' . $message . '</div>'
                );

            // On envoie le mail
            $mailer->send($mail);
            
            // On affiche un message de confirmation
            $this->addFlash('success', 'Votre message a bien été envoyé !');
            
        }



        return $this->render('page/contact.html.twig', [
            'contact' => $form,
        ]);
    }
}
