<?php

namespace App\Controller;

use App\Form\AvatarFormType;
use App\Form\ChangePasswordFormType;
use Doctrine\ORM\EntityManagerInterface;
use Imagine\Gd\Imagine;
use Imagine\Image\Box;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserController extends AbstractController
{
    #[Route('/perfil', name: 'user_profile')]
    public function profile(Request $request)
    {
        $user = $this->getUser();
        if (!$user) {
            return $this->redirectToRoute('app_login');
        }

        $activeTab = $request->query->get('tab', 'datos');
        $avatarform = $this->createForm(AvatarFormType::class);
        $passwordform = $this->createForm(ChangePasswordFormType::class);

        // Lógica para mostrar el perfil del usuario
        return $this->render('profile/profile.html.twig', [
            'user' => $user,
            'avatarForm' => $avatarform->createView(),
            'passwordForm' => $passwordform->createView(),
            'tab' => $activeTab,
        ]);
    }

    #[Route('/perfil/avatar', name: 'profile_avatar', methods: ['POST'])]
    public function changeAvatar(Request $request, EntityManagerInterface $em): Response
    {
        /** @var \App\Entity\User $user */
        $user = $this->getUser();

        $form = $this->createForm(AvatarFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile $avatarFile */
            $avatarFile = $form->get('avatar')->getData();

            if ($avatarFile) {

                $filename = md5(uniqid()) . '.' . $avatarFile->guessExtension();

                // Carpeta donde se guardan los avatares
                $uploadDir = $this->getParameter('avatars_directory');

                try {
                    $avatarFile->move($uploadDir, $filename);

                    // Redimensionar a 100x100 usando Imagine
                    $imagine = new Imagine();
                    $image = $imagine->open($uploadDir . '/' . $filename);
                    $image->resize(new Box(100, 100))->save($uploadDir . '/' . $filename);

                    // Actualizar la entidad
                    $user->setAvatar($filename);
                    $em->persist($user);
                    $em->flush();

                    $this->addFlash('success', 'Avatar actualizado correctamente.');
                } catch (FileException $e) {
                    $this->addFlash('error', 'Error subiendo la imagen.');
                }
            }
        }

        return $this->render('profile/profile.html.twig', [
            'avatarForm' => $form->createView(),
            'user' => $user,
            'tab' => 'avatar',
        ]);
    }

    #[Route('/perfil/password', name: 'profile_password', methods: ['POST'])]
    public function changePassword(
        Request $request,
        UserPasswordHasherInterface $passwordHasher,
        EntityManagerInterface $em
    ): Response {
        /** @var \App\Entity\User $user */
        $user = $this->getUser();

        if (!$user) {
            return $this->redirectToRoute('app_login');
        }

        $form = $this->createForm(ChangePasswordFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $currentPassword = $form->get('currentPassword')->getData();
            $newPassword = $form->get('newPassword')->getData();
            $repeatPassword = $form->get('repeatPassword')->getData();

            if (!$passwordHasher->isPasswordValid($user, $currentPassword)) {
                $this->addFlash('danger', 'La contraseña actual no es correcta.');
                return $this->redirectToRoute('user_profile', ['tab' => 'password']);
            }

            if ($newPassword !== $repeatPassword) {
                $this->addFlash('danger', 'Las nuevas contraseñas no coinciden.');
                return $this->redirectToRoute('user_profile', ['tab' => 'password']);
            }

            $hashedPassword = $passwordHasher->hashPassword($user, $newPassword);
            $user->setPassword($hashedPassword);

            $em->flush();

            $this->addFlash('success', 'Contraseña cambiada correctamente.');

            return $this->redirectToRoute('user_profile', ['tab' => 'password']);
        }

        return $this->redirectToRoute('user_profile', ['tab' => 'password']);
    }
}
