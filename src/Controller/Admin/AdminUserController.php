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


class AdminUserController extends AbstractController
{
    #[Route('/admin/user', name: 'app_admin_user')]
    public function users(UserRepository $repository,Request $request, PaginatorInterface $paginator): Response
    {
        $users = $repository->findBy([], [],);
        $arusr =[];
        foreach ($users as $user) {
            $roles = $user->getRoles();
                if ($roles[0] == 'ROLE_USER') {
                    $arusr[] = $user;
                }
        }
       $users = $arusr;
        $users = $paginator->paginate($users,
            $request->query->getInt('page',1),
            12
        );
        return $this->render('admin/user.html.twig', [
            'users' => $users,
        ]);
    }


    #[Route('/admin/promuser/{id}', 'app_admin_promuser')]
    public function viewPost(User $user, Request $request, EntityManagerInterface $manager): Response
    {
        if  (!$user->isDisabled()){
         /*   dd('PROMOTED');*/
            $user->setRoles(['ROLE_ADMIN']);
            $manager->persist($user);
            $manager->flush();
            $this->addFlash(
                'success',
                "l'utilisateur est maintenant administrateur"
            );
            return $this->redirectToRoute('app_admin_user');
        }
        else{
            $this->addFlash(
                'danger',
                'Vous ne pouvez pas promouvoir ce compte! Ce compte est inactif.'
            );
            return $this->redirectToRoute('app_admin_user');
        }





    }
    #[Route('/admin/disable/{id}', 'app_admin_disuser')]
    public function disableUser(User $user, Request $request, EntityManagerInterface $manager): Response
    {

        $user->setDisabled(!$user->isDisabled());
        $manager->persist($user);
        $manager->flush();

        return $this->redirectToRoute('app_admin_user');

    }
    #[Route('/admin/delete/{id}', 'app_admin_deluser')]
    public function deleteUser(User $user, Request $request, EntityManagerInterface $manager): Response
    {
        if ($user->isDisabled()){
            $manager->remove($user);
            $manager->flush();
            $this->addFlash(
                'success',
                'Le compte a bien été supprimé'
            );
            return $this->redirectToRoute('app_admin_user');}

        else{
            $this->addFlash(
                'danger',
                'Vous ne pouvez pas supprimé ce compte! Ce compte est toujours en fonction.'
            );

    }

        return $this->redirectToRoute('app_admin_user');

    }
}
