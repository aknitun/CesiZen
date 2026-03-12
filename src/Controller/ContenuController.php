<?php

namespace App\Controller;

use App\Entity\Contenu;
use App\Form\ContenuType;
use App\Repository\ContenuRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/contenu')]
final class ContenuController extends AbstractController
{
    #[Route(name: 'app_contenu_index', methods: ['GET'])]
    public function index(ContenuRepository $contenuRepository): Response
    {
        return $this->render('contenu/index.html.twig', [
            'contenus' => $contenuRepository->findBy(['publier' => true]),
        ]);
    }

    #[Route('/new', name: 'app_contenu_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $contenu = new Contenu();
        $form = $this->createForm(ContenuType::class, $contenu);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($contenu);
            $entityManager->flush();

            return $this->redirectToRoute('app_contenu_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('contenu/new.html.twig', [
            'contenu' => $contenu,
            'form' => $form,
        ]);
    }

    #[Route('/informations/{id}', name: 'app_contenu_show', methods: ['GET'])]
    public function show($id, ContenuRepository $contenuRepository): Response
    {
        // On vérifie si $id est un nombre et si le contenu existe
        $contenu = is_numeric($id) ? $contenuRepository->find($id) : null;

        if (!$contenu || !$contenu->isPublier()) {
            $this->addFlash('error', 'Le contenu demandé n\'existe pas ou n\'est plus disponible.');
            return $this->redirectToRoute('app_contenu_index');
        }

        return $this->render('contenu/show.html.twig', [
            'contenu' => $contenu,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_contenu_edit', methods: ['GET', 'POST'], requirements: ['id' => '\d+'])]
    public function edit(Request $request, Contenu $contenu, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ContenuType::class, $contenu);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_contenu_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('contenu/edit.html.twig', [
            'contenu' => $contenu,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_contenu_delete', methods: ['POST'], requirements: ['id' => '\d+'])]
    public function delete(Request $request, Contenu $contenu, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$contenu->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($contenu);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_contenu_index', [], Response::HTTP_SEE_OTHER);
    }
}
