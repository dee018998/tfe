<?php

namespace App\Controller\User;

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
    #[Route('/user/comment', name: 'app_user_comment')]
    public function Comments(): Response
    {

        return $this->render('comment/comments.html.twig',);
    }

    #[Route('/user/newcomment/{id}', name: 'app_user_newcomment')]
    public function newComment( CourseRepository $repo, Request $request, EntityManagerInterface $manager, CommentRepository $repository, $id): Response
    {
        /* $crs = $repo->findBy(['id'=>$id],[]);*/
        /*dd($crs);*/
   /*     $user = $this->getUser();*/

        $user = $this->getUser();
       /* $coursId = $request->request->get('cours_id');*/
        $cours = $repo->find($id);

        /*        $crsid = $crs->getId();
               dd($crsid);*/
        /*        $comments = $this->getComments();
                dd($user);*/

/*        $usrcom = $repository->findBy(['course' => $id, 'user' => $userid], []);*/

     /*  if (!($usrcom)) {*/
           $comment = new Comment();
           $form = $this->createForm(CommentFormType::class, $comment);
           $form->handleRequest($request);
           if ($form->isSubmitted() && $form->isValid()) {
              $comment->setUser($user)
             ->setCourse($cours)
             ->setCreatedAt(new \DateTimeImmutable());
                /* $comment->setCourse($id);*/
               /*    $comment->setCourse($crs);*/
               $manager->persist($comment);
               $manager->flush();
               //dd($comment);
               return $this->redirectToRoute('app_courses');
           }
           return $this->render('comment/newcomment.html.twig', [
               'form' => $form,
           ]);

        }
    #[Route('/user/editcomment/{id}',name: 'app_user_editcomment')]
    public function editComment(MailerInterface $mailer ,Comment $comment, Request $request, EntityManagerInterface $manager): Response
    {
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
                'Votre commentaire a bien a été mise à jour'
            );
            return $this->redirectToRoute('app_courses');
        }
        return $this->render('user/editcomment.html.twig', [
            'form' => $form,
        ]);
    }


}
