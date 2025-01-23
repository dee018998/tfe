<?php

namespace App\Controller;

use App\Repository\CommentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CommentController extends AbstractController
{
    #[Route('/comment', name: 'app_comment')]
    public function Comments(CommentRepository $repository, Request $request, ): Response
    {
        $comments = $repository->findBy(

            ['isPublished' => true],
            ['createdAt' => 'DESC']
        );



        return $this->render('comment/comments.html.twig',);
    }

    #[Route('/comment/rating', name: 'app_comment_rating')]
    public function allRating(CommentRepository $repository, Request $request, ): Response
    {
        $comments = $repository->findBy(

            ['isPublished' => true],
            ['createdAt' => 'DESC']
        );

        $rating = 0;
        foreach ($comments as $comment) {
            $rating = $rating + $comment->getRating();

        }
        $countComment = count($comments);

        $avgComment = $rating / $countComment;


        return $this->render('comment/rating.html.twig',[
            'avgComment' => $avgComment,
            'countComment' => $countComment,
        ]);
    }

}
