<?php

namespace App\Controller;

use App\Form\RequestPasswordResetType;
use App\Form\ResetPasswordType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    #[Route(path: '/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error,
        ]);
    }

    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }

    #[Route(path: '/mot-de-passe-oublie', name: 'app_request_password_reset')]
    public function requestPasswordReset(
        Request        $request,
        UserRepository $userRepository
    ): Response
    {
        $form = $this->createForm(RequestPasswordResetType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $email = $data['email'];
            $reponse = $data['reponseQuestionSecrete'];

            $user = $userRepository->findOneBy(['email' => $email]);

            // Message générique (évite de révéler si l'email existe)
            $errorMessage = 'Informations invalides.';

            if (!$user || !$user->getReponseQuestionSecrete()) {
                $this->addFlash('error', $errorMessage);
                return $this->redirectToRoute('app_request_password_reset');
            }

            // comparaison normalisée
            $expected = mb_strtolower(trim($user->getReponseQuestionSecrete()));
            $given = mb_strtolower(trim($reponse));

            if ($expected !== $given) {
                $this->addFlash('error', $errorMessage);
                return $this->redirectToRoute('app_request_password_reset');
            }

            // OK => session
            $request->getSession()->set('password_reset_user_id', $user->getId());

            return $this->redirectToRoute('app_password_reset_new');
        }

        return $this->render('security/request_password_reset.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route(path: '/mot-de-passe-oublie/nouveau', name: 'app_password_reset_new')]
    public function resetPasswordNew(
        Request                     $request,
        UserRepository              $userRepository,
        EntityManagerInterface      $em,
        UserPasswordHasherInterface $passwordHasher
    ): Response
    {
        $userId = $request->getSession()->get('password_reset_user_id');
        if (!$userId) {
            // si on arrive ici sans avoir passé l'étape 1
            return $this->redirectToRoute('app_request_password_reset');
        }

        $user = $userRepository->find($userId);
        if (!$user) {
            $request->getSession()->remove('password_reset_user_id');
            return $this->redirectToRoute('app_request_password_reset');
        }

        $form = $this->createForm(ResetPasswordType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $plainPassword = $form->get('plainPassword')->getData();

            $hashed = $passwordHasher->hashPassword($user, $plainPassword);
            $user->setPassword($hashed);

            $em->flush();

            // on invalide la session reset
            $request->getSession()->remove('password_reset_user_id');

            $this->addFlash('success', 'Mot de passe modifié. Vous pouvez vous connecter.');
            return $this->redirectToRoute('app_login');
        }

        return $this->render('security/reset_password.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
