<?php

namespace App\Controller;

use App\Form\UserProfileFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    #[Route('/compte', name: 'app_user_show')]
    public function show(): Response
    {
        $user = $this->getUser();

        if (!$user) {
            // Par sécurité, on redirige vers le login si pas connecté
            return $this->redirectToRoute('app_login');
        }

        return $this->render('user/show.html.twig', [
            'user' => $user,
        ]);
    }

    #[Route('/compte/modifier', name: 'app_user_edit')]
    public function edit(
        Request $request,
        EntityManagerInterface $entityManager,
        UserPasswordHasherInterface $passwordHasher
    ): Response {
        $user = $this->getUser();

        if (!$user) {
            return $this->redirectToRoute('app_login');
        }

        $form = $this->createForm(UserProfileFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Récupère le nouveau mot de passe saisi (si le champ n'est pas vide)
            $plainPassword = $form->get('plainPassword')->getData();

            if (!empty($plainPassword)) {
                // Hash avec bcrypt (ou algo configuré dans security.yaml)
                $hashedPassword = $passwordHasher->hashPassword($user, $plainPassword);
                $user->setPassword($hashedPassword);
            }

            $entityManager->flush();

            $this->addFlash('success', 'Votre profil a été mis à jour !');

            return $this->redirectToRoute('app_user_show');
        }

        return $this->render('user/edit.html.twig', [
            'userForm' => $form->createView(),
        ]);
    }
}