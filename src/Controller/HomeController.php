<?php

namespace App\Controller;

use App\Repository\CourseRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(CourseRepository $repository, Request $request,PaginatorInterface $paginator,): Response
    {
        $courses = $repository->findBy(

            ['isPublished' => true],
            ['createdAt' => 'DESC'],
            3

        );
        foreach($courses as $c)
        {
            $comments = $c->getComments();
        }
        $pagination = $paginator->paginate($comments, $request->query->getInt('page',1),4);
        return $this->render('home/index.html.twig',[
            'courses' => $courses,
             'comments' => $pagination,
        ] )
            ;
    }
}
