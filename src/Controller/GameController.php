<?php

namespace App\Controller;

use App\Entity\Game;
use App\Form\GameFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class GameController extends AbstractController
{
    #[Route('/juegos/nuevo', name: 'game_new')]
    public function new(Request $request, EntityManagerInterface $em): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');

        $game = new Game();
        $form = $this->createForm(GameFormType::class, $game);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $game->setUser($this->getUser());

            $imageFile = $form->get('image')->getData();

            if ($imageFile) {
                $filename = md5(uniqid()) . '.' . $imageFile->guessExtension();

                $uploadDir = $this->getParameter('games_directory');

                try {
                    $imageFile->move($uploadDir, $filename);
                    $game->setImage($filename);
                } catch (FileException $e) {
                    $this->addFlash('danger', 'Error subiendo la imagen');
                    return $this->redirectToRoute('game_new');
                }
            }

            $em->persist($game);
            $em->flush();

            $this->addFlash('success', 'Juego añadido correctamente');

            return $this->redirectToRoute('user_profile');
        }

        return $this->render('games/crearjuego.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/misjuegos', name: 'user_games')]
    public function myGames(EntityManagerInterface $em): Response
    {
        $user = $this->getUser();

        if (!$user) {
            return $this->redirectToRoute('app_login');
        }

        $games = $em->getRepository(Game::class)->findBy(
            ['user' => $user],
            ['createdAt' => 'DESC'] 
        );

        return $this->render('games/misjuegos.html.twig', [
            'games' => $games,
        ]);
    }
}
