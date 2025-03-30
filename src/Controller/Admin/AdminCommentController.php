<?php

namespace App\Controller\Admin;

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

class AdminCommentController extends AbstractController
{
    #[Route('/admin/comment', name: 'app_admin_comment')]
    public function comment(CommentRepository $repository, Request $request, PaginatorInterface $paginator): Response
    {
        $pageNbr = $request->query->getInt('page', 1);
        $sort = $request->query->getString('sort', 'null');
        $direction = $request->query->getString('direction', 'ASC');
        $comments = $repository->findBy([], ['createdAt' => 'DESC'],);
        $comments = $paginator->paginate($comments,
            $pageNbr,
            12
        );

        return $this->render('admin/comment.html.twig', [
            'comments' => $comments,
            'page' => $pageNbr,
            'sort' => $sort,
            'direction' => $direction

        ]);
    }

    #[Route('admin/viewcomment/{id}', name: 'app_admin_viewcomment')]
    public function viewComment(MailerInterface $mailer, Comment $comment, Request $request, EntityManagerInterface $manager): Response
    {
        /*        Send Email to inform the user comment is not valid      */
        if ($comment->isPublished() === true && $comment->isModarated() === False) {
            $comment->setPublished(false);

            $email = (new Email())
                ->from('info@webarticle.com')
                ->to($comment->getUser()->getEmail())
                ->subject('Clarification Regarding Your Comment')
                ->text("Dear" .$comment->getUser()->getFirstName(). " ".$comment->getUser()->getLastName() .
                "Thank you for sharing your thoughts with us. 
                Upon review, we noticed that your comment does not align with the context or requirements of the platform guidelines.
                We encourage constructive and accurate contributions to ensure meaningful engagement within our community. 
                If you have any additional insights or questions, feel free to share them.
                We value your participation and look forward to your future contributions!
                Best regards,");
            $mailer->send($email);
            $manager->persist($comment);
            $manager->flush();
            $this->addFlash(
                'success',
                "Le message a été envoyé. Le commentaire est attente de correction."
            );

            return $this->redirectToRoute('app_admin_comment');


        } else if ($comment->isPublished() === false && $comment->isModarated() === True) {
            $comment->setPublished(true)
                ->setModarated(false);

            $email = (new Email())
                ->from('info@online-dj-school.com')
                ->to($comment->getUser()->getEmail())
                ->subject('Commentaire valide')
                ->text("Dear" . "Thank you for sharing your thoughts with us. 
                Upon review, we noticed that your comment does not align with the context or requirements of the platform guidelines.
                We encourage constructive and accurate contributions to ensure meaningful engagement within our community. 
                If you have any additional insights or questions, feel free to share them.
                We value your participation and look forward to your future contributions!
                Best regards,");
            $mailer->send($email);
            $manager->persist($comment);
            $manager->flush();
            $this->addFlash(
                'success',
                "Votre commentaire est en attente d'approbation"
            );

            return $this->redirectToRoute('app_admin_comment');


        }
        $this->addFlash(
            'danger',
            'Vous avez été redirigé'
        );

        return $this->render('comment/comments.html.twig',);
    }


}
