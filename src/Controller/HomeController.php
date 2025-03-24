<?php

namespace App\Controller;

use App\Repository\ActuRepository;
use App\Repository\CourseRepository;
use App\Repository\FamilyRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(CourseRepository $repository, Request $request,PaginatorInterface $paginator,ActuRepository $repo, FamilyRepository $famrepo): Response
    {
        $courses = $repository->findBy(

            ['isPublished' => true],
            ['createdAt' => 'DESC'],
            3

        );
        $actus = [];
        $families = $famrepo->findAll();
        foreach ( $families as $family){
            $actu = $repo->findOneByFamily($family);
            $actus [] = $actu;
        }

/*dd($actus);*/
        foreach($courses as $c)
        {
            $comments = $c->getComments();
        }
        $pagination = $paginator->paginate($comments, $request->query->getInt('page',1),4);
        return $this->render('home/index.html.twig',[
            'courses' => $courses,
             'comments' => $pagination,
            'actus' => $actus,
        ] )
            ;
    }
}
