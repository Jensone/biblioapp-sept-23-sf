<?php

namespace App\Controller;

use Symfony\Component\Mime\Email;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Security\Http\LoginLink\LoginLinkHandlerInterface;

class SecurityController extends AbstractController
{
    #[Route(path: '/login', name: 'app_login')]
    public function requestLoginLink(
        UserRepository $userRepository,
        Request $request,
        LoginLinkHandlerInterface $loginLinkHandler,
        MailerInterface $mailer
    ): Response
    {
        if ($request->isMethod('POST')) {
            // Recherche de l'utilisateur par son email
            $email = $request->request->get('email');
            $user = $userRepository->findOneBy(['email' => $email]);

            // Création du lien de connexion unique pour l'utilisateur
            $loginLinkDetails = $loginLinkHandler->createLoginLink($user);

            // Récupération du lien de connexion
            $loginLink = $loginLinkDetails->getUrl();
            
            // Envoi par mail du lien de connexion
            $mail = (new Email())
                ->from($email)
                ->to('contact@biblioapp.fr')
                ->priority(Email::PRIORITY_HIGH)
                ->subject('Votre lien de connexion')
                ->html(
                    '<div>
                    Voici votre lien de connexion : <br> <a href="' . $loginLink . '">' . $loginLink . '</a> <br> Attention le lien expire dans 10 min.</div>'
                );

            // On envoie le mail
            $mailer->send($mail);

            return new Response('Vérifiez vos mails pour vous connecter');
            
        }

        return $this->render('security/login.html.twig');
    }

    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}
