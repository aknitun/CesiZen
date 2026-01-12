<?php

namespace App\Controller;

use App\Form\UserProfileFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    #[Route('/compte', name: 'app_user_edit')]
    public function edit(Request $request, EntityManagerInterface $entityManager): Response
    {
        // Récupère l'utilisateur connecté
        $user = $this->getUser();

        $form = $this->createForm(UserProfileFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            $this->addFlash('success', 'Votre profil a été mis à jour !');

            return $this->redirectToRoute('app_home');
        }

        return $this->render('user/edit.html.twig', [
            'userForm' => $form->createView(),
        ]);
    }
}
