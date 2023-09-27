<?php

namespace App\Controller\Admin;

use App\Entity\Book;
use App\Entity\Author;
use App\Entity\Client;
use App\Entity\Editor;
use App\Entity\Format;
use App\Entity\Category;
use App\Entity\Language;
use App\Entity\User;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;

class DashboardController extends AbstractDashboardController
{
    #[Route('/', name: 'admin')]
    public function index(): Response
    {
        // Option 3. You can render some custom template to display a proper dashboard with widgets, etc.
        // (tip: it's easier if your template extends from @EasyAdmin/page/content.html.twig)
        //
        return $this->render('admin/dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Biblioapp');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToCrud('Bibliothèque', 'fas fa-book', Book::class);
        yield MenuItem::section('Autorités');
        yield MenuItem::linkToCrud('Auteurs', 'fas fa-pen-nib', Author::class);
        yield MenuItem::linkToCrud('Éditeurs', 'fas fa-building', Editor::class);
        yield MenuItem::linkToCrud('Clients', 'fas fa-users', Client::class);
        yield MenuItem::section('Paramètres');
        yield MenuItem::linkToCrud('Catégories', 'fas fa-list', Category::class);
        yield MenuItem::linkToCrud('Formats', 'fas fa-arrows-up-down-left-right', Format::class);
        yield MenuItem::linkToCrud('Langues', 'fas fa-language', Language::class);
        yield MenuItem::section('Autres');
        yield MenuItem::linkToCrud('Utilisateurs', 'fas fa-users', User::class);
        yield MenuItem::linkToRoute('Retour au site', 'fas fa-arrow-left', 'app_page');
    }
}
