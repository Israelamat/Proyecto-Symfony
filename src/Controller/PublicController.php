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

    #[Route('/login', name: 'login')]
    public function login(): Response
    {
        return $this->render('login.html.twig');
    }

    #[Route('/register', name: 'register')]
    public function register(): Response
    {
        return $this->render('register.html.twig');
    }

    #[Route('/detalles', name: 'detalles')]
    public function detalles(): Response
    {
        return $this->render('detalles.html.twig');
    }


    #[Route('/usuarios', name: 'usuarios')]
    public function usuarios(): Response
    {
        // Array de usuarios de ejemplo
        $users = [
            [
                'name' => 'Erika López',
                'email' => 'erika@example.com',
                'type' => 'admin',
            ],
            [
                'name' => 'Carlos Pérez',
                'email' => 'carlos@example.com',
                'type' => 'normal',
            ],
            [
                'name' => 'Laura Gómez',
                'email' => 'laura@example.com',
                'type' => 'normal',
            ],
            [
                'name' => 'Juan Martínez',
                'email' => 'juan@example.com',
                'type' => 'admin',
            ],
        ];

        return $this->render('gestion-usuarios.html.twig', [
            'users' => $users
        ]);
    }
}
