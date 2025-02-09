<?php

namespace App\Controller\Client;

use App\Entity\Comment;
use App\Entity\User;
use App\Form\CommentFormType;
use App\Repository\CommentRepository;
use App\Repository\CourseRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Attribute\Route;

class CommentController extends AbstractController
{
    #[Route('/client/comment', name: 'app_user_comment')]
    public function Comments(): Response
    {

        return $this->render('comment/comments.html.twig',);
    }

    #[Route('/client/newcomment/{id}', name: 'app_client_newcomment')]
    public function newComment( CourseRepository $repo, Request $request, EntityManagerInterface $manager, CommentRepository $repository, $id): Response
    {

        /* $crs = $repo->findBy(['id'=>$id],[]);*/
        /*dd($crs);*/
        /*     $user = $this->getUser();*/

        $user = $this->getUser();

        /* $coursId = $request->request->get('cours_id');*/
        $cour = $repo->find($id);


        $users = $cour->getUsers();

        /* if ($users->contains($user)) {*/

        /*   $comments = $cour->getComments();
        /*        $crsid = $crs->getId();
                dd($crsid);*/
        /*        $comments = $this->getComments();
                dd($user);*/
        if ($users->contains($user)) {
            $usrcom = $repository->findBy(['course' => $id, 'user' => $user], []);

            if (!($usrcom)) {

                $comment = new Comment();
                $form = $this->createForm(CommentFormType::class, $comment);
                $form->handleRequest($request);

                if ($form->isSubmitted()) {

                    $comment->setUser($user)
                        ->setCourse($cour)
                        ->setCreatedAt(new \DateTimeImmutable())
                        ->setPublished(true)
                        ->setModarated(false);
                    /* $comment->setCourse($id);*/
                    /*    $comment->setCourse($crs);*/
                    $manager->persist($comment);
                    $manager->flush();
                    //dd($comment);
                    return $this->redirectToRoute('app_client');
                }
                return $this->render('comment/newcomment.html.twig', [
                    'form' => $form,
                ]);

            }
            return $this->redirectToRoute('app_home');
        }
        return $this->redirectToRoute('app_home');
    }
/*        return $this->render('fragment/_message.html.twig', [
            'message' => "You already rated this course",
        ]);
    }*/

  /*      }
        return $this->render('fragment/_message.html.twig', [
            'message' => "You don't own this course",
        ]);

    }*/




    #[Route('/client/editcomment/{id}',name: 'app_client_editcomment')]
    public function editComment(MailerInterface $mailer ,Comment $comment, Request $request, EntityManagerInterface $manager): Response
    {   $user = $this->getUser();
        if (($comment->getUser()) === $user && !$comment->isModarated() && !$comment->isPublished() ){
/*            dd($user);*/
            $form = $this->createForm(CommentFormType::class, $comment);

            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $comment->setModarated(true);
                $manager->persist($comment);
                $email = (new Email())
                    ->from('info@mycourse.com')
                    ->to('comment@mycourse.com')
                    ->subject('Mise à jour du commentaire de '. $comment->getUser()->getEmail())
                    ->text($form->getData()->getContent());
                $mailer->send($email);
                $manager->persist($comment);
                $manager->flush();
                $this->addFlash(
                    'success',
                    'Your comment is waiting for approval'
                );
                return $this->redirectToRoute('app_home');
            }
            return $this->render('client/editcomment.html.twig', [
                'form' => $form,
            ]);
        }
        return $this->redirectToRoute('app_home');

    }






}
