<?php

namespace App\Controller\Moderator;

use App\Entity\Comment;
use App\Repository\CommentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use phpDocumentor\Reflection\PseudoTypes\True_;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Attribute\Route;

class ModeratorCommentController extends AbstractController
{
    #[Route('/moderator/comment', name: 'app_mod_comment')]
    public function comment(CommentRepository $repository, Request $request, PaginatorInterface $paginator): Response
    {
        $comments = $repository->findBy([], ['createdAt' => 'DESC'], );
        $comments = $paginator->paginate($comments,
            $request->query->getInt('page', 1),
            12
        );
        $user = $this->getUser()->getRoles();
        if ($user[0] == 'ROLE_ADMIN' or $user[0] == 'ROLE_SUPER_ADMIN'  ){

            return $this->render('admin/comment.html.twig', [
                'comments' => $comments,
            ]);
        }

        return $this->render('moderator/comment.html.twig', [
            'comments' => $comments,
        ]);
    }

    #[Route('moderator/viewcomment/{id}', name: 'app_mod_viewcomment')]
    public function viewComment(MailerInterface $mailer, Comment $comment, Request $request, EntityManagerInterface $manager): Response
    {
        if ($comment->isPublished() === true && $comment->isModarated() === False) {
            $comment->setPublished(false);

            $email = (new Email())
                ->from('info@webarticle.com')
                ->to($comment->getUser()->getEmail())
                ->subject('Commentaire non conforme')
                ->text('Bla bla bla bla commentaire non conforme');
            $mailer->send($email);
            $manager->persist($comment);
            $manager->flush();
            $this->addFlash(
                'success',
                'Le message a été envoyé'
            );

            return $this->redirectToRoute('app_mod_comment');


        } else if ($comment->isPublished() === false && $comment->isModarated() === True) {
            $comment->setPublished(true)
                    ->setModarated(false);

            $email = (new Email())
                ->from('info@webarticle.com')
                ->to($comment->getUser()->getEmail())
                ->subject('Commentaire valide')
                ->text('Votre commentaire est conforme, il a été publié');
            $mailer->send($email);
            $manager->persist($comment);
            $manager->flush();
            $this->addFlash(
                'success',
                "Waiting user to reply"
            );

            return $this->redirectToRoute('app_mod_comment');


        }
        $this->addFlash(
            'danger',
            'Vous avez été redirigé'
        );

        return $this->render('comment/comments.html.twig',);
    }


}
