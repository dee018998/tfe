<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class AdminTeamController extends AbstractController
{
    #[Route('/admin/team', name: 'app_admin_team')]
    public function admins(UserRepository $repository, Request $request, PaginatorInterface $paginator): Response
    {
        $users = $repository->findBy([], [],);
        $arusr = [];
        foreach ($users as $user) {
            $roles = $user->getRoles();
            if ($roles[0] == 'ROLE_ADMIN') {
                $arusr[] = $user;
            }
        }

        $users = $arusr;
        $users = $paginator->paginate($users,
            $request->query->getInt('page',1),
            12
        );

        return $this->render('admin/admin.html.twig', [
            'users' => $users,
        ]);
    }

    #[Route('admin/team/promadmin/{id}', name: 'app_admin_team_promadmin')]
    public function promAdmin(User $user, Request $request, EntityManagerInterface $manager): Response
    {
        /*dd('PROMADMIN');*/
        if (!$user->isDisabled()) {
            $user->setRoles(['ROLE_SUPER_ADMIN']);
            $manager->persist($user);
            $manager->flush();
            $this->addFlash(
                'success',
                "l'administrateur a été promu GOD"
            );
            return $this->redirectToRoute('app_admin_team');
        } else {
            $this->addFlash(
                'danger',
                'Vous ne pouvez pas promouvoir ce compte! Ce compte est inactif.'
            );
            return $this->redirectToRoute('app_admin_team');

        }
    }

    #[Route('admin/team/disadmin/{id}', name: 'app_admin_team_disadmin')]
    public function disAdmin(User $user, Request $request, EntityManagerInterface $manager): Response
    {
        $user->setDisabled(!$user->isDisabled());
        $manager->persist($user);
        $manager->flush();
        return $this->redirectToRoute('app_admin_team');

    }

    #[Route('admin/team/deladmin/{id}', name: 'app_admin_team_deladmin')]
    public function delAdmin(User $user, Request $request, EntityManagerInterface $manager): Response
    {
        if ($user->isDisabled()) {
            $manager->remove($user);
            $manager->flush();
            $this->addFlash(
                'success',
                'Le compte a bien été supprimé'
            );

            return $this->redirectToRoute('app_admin_team');

        }
        else{
            $this->addFlash(
            'danger',
            'Vous ne pouvez pas supprimé ce compte! Ce compte est toujours en fonction.'
        );

        }
        return $this->redirectToRoute('app_admin_team');
        }
    }


