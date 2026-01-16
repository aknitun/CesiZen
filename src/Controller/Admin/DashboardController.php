<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Entity\Contenu;
use App\Entity\ExerciceRespiration;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        // Rend une vue Twig "page d'accueil" du backoffice
        return $this->render('admin/dashboard.html.twig', [
            'user' => $this->getUser(),
        ]);
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('CesiZen - Administration');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToRoute('Retour au site', 'fa fa-home', 'app_home');
        yield MenuItem::section('Gestion');
        yield MenuItem::linkToCrud('Utilisateurs', 'fa fa-users', User::class);
        yield MenuItem::linkToCrud('Contenus', 'fa fa-file-alt', Contenu::class);
        yield MenuItem::linkToCrud('Exercices de respiration', 'fa fa-wind', ExerciceRespiration::class);
    }
}