<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class PublicController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(): Response
    {
        return $this->render('home/index.html.twig');
    }

    #[Route('/test', name: 'test')]
    public function test(): Response
    {
        return $this->render('test.html.twig');
    }

    #[Route('/logintest', name: 'testlogin')]
    public function login(): Response
    {
        return $this->render('oldlogin.html.twig');
    }

    #[Route('/registertest', name: 'testregister')]
    public function register(): Response
    {
        return $this->render('oldregister.html.twig');
    }

    #[Route('/detalles', name: 'detalles')]
    public function detalles(): Response
    {
        return $this->render('detalles.html.twig');
    }

    /*
    #[Route('/misjuegos', name: 'misjuegos')]
    public function misjuegos(): Response
    {
        $games = [
            [
                'title' => 'Elden Ring',
                'date' => '2024-01-14',
                'price' => '40.00',
                'genres' => ['RPG', 'Acción']
            ],
            [
                'title' => 'FIFA 24',
                'date' => '2023-11-02',
                'price' => '35.00',
                'genres' => ['Deportes']
            ],
            [
                'title' => 'Civilization VI',
                'date' => '2023-09-20',
                'price' => '25.00',
                'genres' => ['Estrategia']
            ],
            [
                'title' => 'The Witcher 3',
                'date' => '2023-08-05',
                'price' => '30.00',
                'genres' => ['RPG', 'Aventura']
            ],
        ];

        return $this->render('games/misjuegos.html.twig', [
            'games' => $games
        ]);
    }
    */

    #[Route('/miscompras', name: 'miscompras')]
    public function miscompras(): Response
    {
        $games = [
            [
                'title' => 'The Witcher 3',
                'date' => '2023-08-05',
                'price' => '30.00',
                'genres' => ['RPG', 'Aventura']
            ],
        ];

        return $this->render('miscompras.html.twig', [
            'games' => $games
        ]);
    }


}
