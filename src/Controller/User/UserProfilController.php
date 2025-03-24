<?php

namespace App\Controller\User;

use App\Entity\User;
use App\Form\ChangePasswordFormType;
use App\Form\RegistrationFormType;
use App\Form\UserFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;

class UserProfilController extends AbstractController
{
    #[Route('/user/profil', name: 'app_user_profil')]
    public function userProfil(): Response

    {
        $user = $this->getUser();
        $role = "user";
        return $this->render('user/profil.html.twig', ['user' => $user, 'role' => $role],);

    }

    #[Route('user/edituser/{id}', 'app_user_edituser')]
    public function editUser(User $user, Request $request, EntityManagerInterface $manager): Response
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_login');
        } elseif (($this->getUser()) === $user) {
            $form = $this->createForm(UserFormType::class, $user);
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $user->setUpdatedAt(new \DateTimeImmutable());
                $manager->persist($user);
                $manager->flush();
                $this->addFlash(
                    'success',
                    'Your profil has been updated'
                );
                if(in_array($this->getUser()->getRoles()[0], ['ROLE_USER' , 'ROLE_ADMIN' , 'ROLE_SUPER_ADMIN']) ){
                    return $this->redirectToRoute('app_user_profil');
                }
                if($this->getUser()->getRoles()[0] == 'ROLE_CLIENT'){
                    return $this->redirectToRoute('app_client');
                }
            }
            return $this->render('user/edituser.html.twig', [
                'form' => $form,
            ]);

        }
        $this->addFlash(
            'success',
            "ACCES REFUSE"
        );
        return $this->redirectToRoute('app_home');

    }

    #[Route ('/user/editpassword/{id}', 'app_user_editpassword')]
    public function editUserPassword(User $user, Request $request, EntityManagerInterface $manager, UserPasswordHasherInterface $hasher): response
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_login');
        } elseif (($this->getUser()) === $user) {
            $form = $this->createForm(ChangePasswordFormType::class);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $plainPassword  = $form->get('plainPassword')->getData();
 /*dd($plainPassword);*/

                    $user->setUpdatedAt(new \DateTimeImmutable())
                        ->setPassword($hasher->hashPassword($user, $plainPassword));
                    $manager->persist($user);
                    $manager->flush();
                    $this->addFlash(
                        'success',
                        'Votre mot de passe a été mise à jour'
                    );
                    return $this->redirectToRoute('app_user_profil');
                }


            return $this->render('user/editpassword.html.twig', [
                'form' => $form
            ]);
        }
        $this->addFlash(
            'success',
            "ACCES REFUSE"
        );
        return $this->redirectToRoute('app_home');

    }


}
