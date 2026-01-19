<?php

namespace App\Controller;

use App\Entity\Game;
use App\Entity\Purchase;
use App\Form\GameFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;

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

    #[Route('/juegos/propios', name: 'user_games')]
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

    #[Route('/juegos/{id}', name: 'game_show')]
    public function show(Game $game): Response
    {
        $user = $this->getUser();

        $isOwner = $user && $game->getUser() === $user;

        return $this->render('games/detalles.html.twig', [
            'game' => $game,
            'isOwner' => $isOwner,
        ]);
    }

    #[Route('/juegos/{id}/editar', name: 'game_edit')]
    public function edit(
        Game $game,
        Request $request,
        EntityManagerInterface $em
    ): Response {
        if ($game->getUser() !== $this->getUser() && !$this->isGranted('ROLE_ADMIN')) {
            throw $this->createAccessDeniedException();
        }

        $form = $this->createForm(GameFormType::class, $game, [
            'image_required' => false, 
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $imageFile = $form->get('image')->getData();

            if ($imageFile) {
                $filename = uniqid() . '.' . $imageFile->guessExtension();
                $imageFile->move(
                    $this->getParameter('games_directory'),
                    $filename
                );

                $game->setImage($filename);
            }

            $em->flush();

            $this->addFlash('success', 'Juego actualizado correctamente');

            return $this->redirectToRoute('user_games');
        }

        return $this->render('games/editarjuego.html.twig', [
            'form' => $form->createView(),
            'game' => $game,
        ]);
    }


    #[Route('/juegos/eliminar/{id}', name: 'game_delete', methods: ['GET', 'POST'])]
    public function delete(Game $game, EntityManagerInterface $em): RedirectResponse
    {
        $user = $this->getUser();

        if ($game->getUser() !== $user && !$this->isGranted('ROLE_ADMIN')) {
            $this->addFlash('error', 'No puedes eliminar un juego que no te pertenece.');
            return $this->redirectToRoute('user_games');
        }

        if ($game->getPurchase() !== null) {
            $this->addFlash('error', 'No puedes eliminar este juego porque ya ha sido comprado.');
            return $this->redirectToRoute('game_show', ['id' => $game->getId()]);
        }

        $em->remove($game);
        $em->flush();

        $this->addFlash('success', "El juego '{$game->getTitle()}' ha sido eliminado correctamente.");
        return $this->redirectToRoute('user_games');
    }


    #[Route('/compras', name: 'user_purchases')]
    public function showPurchases(EntityManagerInterface $em): Response
    {
        $user = $this->getUser();

        $purchases = $em->getRepository(Purchase::class)
            ->findBy(['buyer' => $user], ['purchasedAt' => 'DESC']);

        return $this->render('purchases/miscompras.html.twig', [
            'purchases' => $purchases
        ]);

    }
}
