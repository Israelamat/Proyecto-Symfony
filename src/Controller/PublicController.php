<?php

namespace App\Controller;

use App\Repository\GameRepository;
use App\Repository\GenreRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
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
        $userId = $request->query->get('user');
        $genreName = $request->query->get('genre_name');

        if (!$genreId && $genreName) {
            // Para el caso de que se filtre por nombre de género desde el footer
            $genre = $genreRepo->findOneBy(['name' => $genreName]);
            $genreId = $genre ? $genre->getId() : null;
        }

        $games = $gameRepository->findAvailableGamesFiltered($genreId, $dateFrom, $dateTo, $search, $userId);
        $genres = $genreRepo->findAll();

        return $this->render('home/index.html.twig', [
            'games' => $games,
            'genres' => $genres,
        ]);
    }

    #[Route('/about-us', name: 'about_us')]
    public function aboutUs(): Response
    {
        return $this->render('home/aboutus.html.twig'); 
    }

    #[Route('/contact-us', name: 'contact_us')]
    public function contactUs(Request $request, MailerInterface $mailer): Response
    {
        if ($request->isMethod('POST')) {
            $name = $request->request->get('name');
            $email = $request->request->get('email');
            $subject = $request->request->get('subject');
            $messageContent = $request->request->get('message');

            if (!$name || !$email || !$subject || !$messageContent) {
                $this->addFlash('error', 'Todos los campos son obligatorios.');
                return $this->redirectToRoute('contact_us');
            }

            $emailMessage = (new Email())
                ->from('noreply@gamehub.com') 
                ->to($email) 
                ->subject('Hemos recibido tu mensaje: ' . $subject)
                ->html($this->renderView('emails/contacto.html.twig', [
                    'name' => $name,
                    'subject' => $subject,
                    'message' => $messageContent,
                ]));

            try {
                $mailer->send($emailMessage);
                $this->addFlash('success', 'Tu mensaje ha sido enviado. Revisa tu correo para confirmación.');
            } catch (\Exception $e) {
                $this->addFlash('error', 'No se pudo enviar el mensaje. Inténtalo más tarde.');
            }

            return $this->redirectToRoute('contact_us');
        }

        return $this->render('home/contactus.html.twig');
    }

}
