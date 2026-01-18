<?php

namespace App\Controller;

use App\Repository\GameRepository;
use App\Repository\GenreRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class PublicController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(Request $request, GameRepository $gameRepository, GenreRepository $genreRepo): Response
    {
        $genreId = $request->query->get('genre') ?: null;
        $dateFrom = $request->query->get('date_from') ? new \DateTime($request->query->get('date_from')) : null;
        $dateTo = $request->query->get('date_to') ? new \DateTime($request->query->get('date_to')) : null;
        $search = $request->query->get('q') ?: null;

        $games = $gameRepository->findAvailableGamesFiltered($genreId, $dateFrom, $dateTo, $search);
        $genres = $genreRepo->findAll();

        return $this->render('home/index.html.twig', [
            'games' => $games,
            'genres' => $genres,
        ]);
    }
}
