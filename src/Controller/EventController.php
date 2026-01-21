<?php

namespace App\Controller;

use App\Entity\Event;
use App\Form\EventFormType;
use App\Repository\GameRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class EventController extends AbstractController
{
    #[Route('/eventos/nuevo', name: 'event_new')]
    public function new(
        Request $request,
        EntityManagerInterface $em,
        GameRepository $gameRepository
    ): Response {
        $user = $this->getUser();

        $event = new Event();
        $event->setOrganizer($user);

        // 👉 SOLO juegos del usuario
        $userGames = $gameRepository->findBy([
            'user' => $user
        ]);

        $form = $this->createForm(EventFormType::class, $event, [
            'user_games' => $userGames
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($event);
            $em->flush();

            $this->addFlash('success', 'Evento creado correctamente');
            return $this->redirectToRoute('user_games');
        }

        return $this->render('events/crearevento.html.twig', [
            'form' => $form
        ]);
    }
}
