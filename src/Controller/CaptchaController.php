<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Attribute\Route;

class CaptchaController extends AbstractController
{
    #[Route('/captcha', name: 'captcha')]
    public function captcha(SessionInterface $session): Response
    {
        // Número aleatorio
        $code = random_int(1000, 9999);
        $session->set('captcha_code', $code);

        // Crear imagen
        $image = imagecreate(120, 40);
        $bg = imagecolorallocate($image, 255, 255, 255);
        $textColor = imagecolorallocate($image, 0, 0, 0);

        imagestring($image, 5, 35, 10, $code, $textColor);

        ob_start();
        imagepng($image);
        $imageData = ob_get_clean();

        imagedestroy($image);

        return new Response($imageData, 200, [
            'Content-Type' => 'image/png',
            'Cache-Control' => 'no-cache, no-store, must-revalidate',
        ]);
    }
}
