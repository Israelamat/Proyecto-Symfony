<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin')]
class AdminController extends AbstractController
{
    #[Route('/usuarios', name: 'admin_users')]
    public function usuarios(Request $request, EntityManagerInterface $em): Response
    {
        $typeFilter = $request->query->get('type') ?? '';
        $nameSearch = $request->query->get('name') ?? '';

        $repo = $em->getRepository(User::class);
        $qb = $repo->createQueryBuilder('u');

        if ($nameSearch) {
            $qb->andWhere('LOWER(u.name) LIKE :name')
                ->setParameter('name', '%' . strtolower($nameSearch) . '%');
        }

        $users = $qb->getQuery()->getResult();

        if ($typeFilter) {
            $users = array_filter($users, function ($user) use ($typeFilter) {
                $roles = $user->getRoles();

                if ($typeFilter === 'admin') {
                    return in_array('ROLE_ADMIN', $roles);
                }

                if ($typeFilter === 'user') {
                    return in_array('ROLE_USER', $roles) && !in_array('ROLE_ADMIN', $roles);
                }

                return true;
            });
        }

        return $this->render('admin/gestion-usuarios.html.twig', [
            'users' => $users,
            'typeFilter' => $typeFilter,
            'nameSearch' => $nameSearch,
        ]);
    }

    #[Route('/usuarios/cambiar-tipo/{id}', name: 'admin_users_change_type', methods: ['POST'])]
    public function cambiarTipo(User $user, EntityManagerInterface $em, Request $request): Response
    {

        $roles  = $user->getRoles();

        if (in_array('ROLE_ADMIN', $roles)) {
            $user->setRoles(['ROLE_USER']);
            $newType = 'normal';
        } else {
            $user->setRoles(['ROLE_USER', 'ROLE_ADMIN']);
            $newType = 'administrador';
        }

        $em->persist($user);
        $em->flush();

        $this->addFlash('success', "Tipo de usuario de {$user->getName()} cambiado a {$newType}.");

        return $this->redirectToRoute('admin_users');
    }

    #[Route('/usuarios/eliminar/{id}', name: 'admin_users_delete', methods: ['POST'])]
    public function eliminar(User $user, EntityManagerInterface $em, Request $request): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        if ($user->getGames() && count($user->getGames()) > 0) {
            $this->addFlash('error', 'No puedes eliminar este usuario porque tiene juegos creados.');
            return $this->redirectToRoute('admin_users');
        }

        if ($user->getPurchases() && $user->getPurchases()->count() > 0) {
            $this->addFlash('error','No se puede eliminar el usuario porque ha realizado compras.');
            return $this->redirectToRoute('admin_users');
        }

        $em->remove($user);
        $em->flush();

        $this->addFlash('success', "Usuario {$user->getName()} eliminado correctamente.");

        return $this->redirectToRoute('admin_users');
    }
}
