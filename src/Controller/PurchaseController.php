<?php

namespace App\Controller;

use App\Entity\Game;
use App\Entity\Purchase;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Twig\Environment;

class PurchaseController extends AbstractController
{
    #[Route('/juego/{id}/comprar', name: 'game_buy')]
    public function buy(Game $game): Response
    {
        $user = $this->getUser();

        if (!$user) {
            return $this->redirectToRoute('app_login');
        }

        if ($game->getUser() === $user) {
            $this->addFlash('error', 'No puedes comprar tu propio juego.');
            return $this->redirectToRoute('game_show', ['id' => $game->getId()]);
        }

        if ($game->getPurchase()) {
            $this->addFlash('error', 'Este juego ya ha sido comprado.');
            return $this->redirectToRoute('game_show', ['id' => $game->getId()]);
        }

        return $this->render('purchases/confirm-purchase.html.twig', [
            'game' => $game
        ]);
    }

    #[Route('/juego/confirmarcompra/{id}', name: 'game_buy_confirm', methods: ['POST'])]
    public function confirm(Game $game, EntityManagerInterface $em, MailerInterface $mailer, Environment $twig,  UrlGeneratorInterface $urlGenerator): Response
    {
        $user = $this->getUser();

        if ($game->getPurchase() || $game->getUser() === $user) {
            $this->addFlash('error', 'Compra no permitida.');
            return $this->redirectToRoute('home');
        }

        $purchase = new Purchase();
        $purchase->setBuyer($user);
        $purchase->setGame($game);
        $purchase->setPrice($game->getPrice());
        $purchase->setPurchasedAt(new \DateTimeImmutable());

        $em->persist($purchase);
        $em->flush();

        $owner = $game->getUser();
        $buyer = $this->getUser();

        $gameUrl = $urlGenerator->generate(
            'game_show',
            ['id' => $game->getId()],
            UrlGeneratorInterface::ABSOLUTE_URL
        );

        $html = $twig->render('emails/juegocomprado.html.twig', [
            'buyer' => $buyer,
            'game' => $game,
            'gameUrl' => $gameUrl,
        ]);

        $email = (new Email())
            ->from('no-reply@gamehub.com')
            ->to($game->getUser()->getEmail())
            ->subject('Tu juego ha sido vendido 🎮')
            ->html($html);

        $mailer->send($email);

        $this->addFlash('success', '¡Compra realizada con éxito!');

        return $this->redirectToRoute('user_purchases');
    }
}
