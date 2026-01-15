<?php

namespace App\Controller;

use App\Entity\ExerciceRespiration;
use App\Entity\SessionExercice;
use App\Entity\User;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SessionExerciceController extends AbstractController
{
    #[Route('/api/session-exercice', name: 'app_session_exercice_create', methods: ['POST'])]
    public function create(
        Request $request,
        EntityManagerInterface $entityManager
    ): JsonResponse {
        /** @var User|null $user */
        $user = $this->getUser();
        if (!$user instanceof User) {
            return new JsonResponse(['error' => 'Non authentifié'], 401);
        }

        $data = json_decode($request->getContent(), true);
        if (!is_array($data)) {
            return new JsonResponse(['error' => 'Données invalides'], 400);
        }

        $exerciceId = $data['exerciceId'] ?? null;
        $startTs    = $data['start'] ?? null;
        $endTs      = $data['end'] ?? null;
        $completed  = $data['completed'] ?? null; // true/false

        if (!$exerciceId || !$startTs || !$endTs || !is_bool($completed)) {
            return new JsonResponse(['error' => 'Champs manquants'], 400);
        }

        /** @var ExerciceRespiration|null $exercice */
        $exercice = $entityManager->getRepository(ExerciceRespiration::class)->find($exerciceId);
        if (!$exercice) {
            return new JsonResponse(['error' => 'Exercice introuvable'], 404);
        }

        $session = new SessionExercice();
        $session
            ->setUtilisateur($user)
            ->setExerciceRespiration($exercice)
            ->setDateDebut((new DateTime())->setTimestamp((int) $startTs))
            ->setDateFin((new DateTime())->setTimestamp((int) $endTs))
            ->setStatut($completed ? 'terminee' : 'interrompue');

        $entityManager->persist($session);
        $entityManager->flush();

        return new JsonResponse([
            'status' => 'ok',
            'sessionId' => $session->getId(),
        ]);
    }

    #[Route('/mes-exercices', name: 'app_session_exercice_history')]
    public function history(Request $request, EntityManagerInterface $entityManager): Response
    {
        /** @var User|null $user */
        $user = $this->getUser();
        if (!$user instanceof User) {
            throw $this->createAccessDeniedException('Vous devez être connecté pour voir votre historique.');
        }

        $page  = max(1, (int) $request->query->get('page', 1));
        $limit = (int) $request->query->get('limit', 10);

        $allowedLimits = [10, 20, 50, 100];
        if ($limit === -1) {
            // -1 = tout
        } elseif (!in_array($limit, $allowedLimits, true)) {
            $limit = 10;
        }

        // Tri (sans "rythme")
        $sort      = (string) $request->query->get('sort', 'date');
        $direction = strtolower((string) $request->query->get('direction', 'desc'));

        $allowedSorts = ['date', 'exercice', 'statut'];
        if (!in_array($sort, $allowedSorts, true)) {
            $sort = 'date';
        }

        if (!in_array($direction, ['asc', 'desc'], true)) {
            $direction = 'desc';
        }

        // Mapping sort -> champs Doctrine
        switch ($sort) {
            case 'exercice':
                $orderField = 'e.nom';
                break;
            case 'statut':
                $orderField = 's.statut';
                break;
            case 'date':
            default:
                $orderField = 's.dateDebut';
                break;
        }

        $repo = $entityManager->getRepository(SessionExercice::class);

        // 1) Total (sans ORDER BY)
        $countQb = $repo->createQueryBuilder('s_count')
            ->select('COUNT(s_count.id)')
            ->andWhere('s_count.utilisateur = :user')
            ->setParameter('user', $user);

        $total = (int) $countQb->getQuery()->getSingleScalarResult();

        // 2) Liste avec order + pagination
        if ($limit === -1) {
            $listQb = $repo->createQueryBuilder('s')
                ->leftJoin('s.exerciceRespiration', 'e')
                ->addSelect('e')
                ->andWhere('s.utilisateur = :user')
                ->setParameter('user', $user)
                ->orderBy($orderField, $direction);

            $sessions = $listQb->getQuery()->getResult();
            $totalPages = 1;
            $page = 1;
        } else {
            $totalPages = max(1, (int) ceil($total / $limit));
            if ($page > $totalPages) {
                $page = $totalPages;
            }
            $offset = ($page - 1) * $limit;

            $listQb = $repo->createQueryBuilder('s')
                ->leftJoin('s.exerciceRespiration', 'e')
                ->addSelect('e')
                ->andWhere('s.utilisateur = :user')
                ->setParameter('user', $user)
                ->orderBy($orderField, $direction)
                ->setFirstResult($offset)
                ->setMaxResults($limit);

            $sessions = $listQb->getQuery()->getResult();
        }

        return $this->render('session_exercice/history.html.twig', [
            'sessions'       => $sessions,
            'page'           => $page,
            'limit'          => $limit,
            'total'          => $total,
            'total_pages'    => $totalPages,
            'allowed_limits' => $allowedLimits,
            'sort'           => $sort,
            'direction'      => $direction,
        ]);
    }
}