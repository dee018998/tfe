<?php

namespace App\Controller;

use App\Entity\Actu;

use App\Entity\Family;
use App\Repository\ActuRepository;
use App\Repository\FamilyRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ActuController extends AbstractController
{
    #[Route('/news', name: 'app_actus')]
    public function actus(ActuRepository $repository,FamilyRepository $repo, Request $request, PaginatorInterface $paginator): Response
    {
        $actus = $repository->findBy(
            ['isPublished' => true],
            ['createdAt' => 'DESC'],
        );
        $families = $repo->findAll();
        $actus = $paginator->paginate($actus,
            $request->query->getInt('page',1),
            9
        );

        return $this->render('news/actus.html.twig',['actus'=>$actus,
                'family' => 'All',
                'families' => $families]
        );
    }
    #[Route('/news/slug/{slug}', name: 'app_actu')]
    public function actu( ActuRepository $repository,string $slug): Response
    {
        $actu = $repository->findOneBy(['slug' => $slug]);
        return $this->render('news/actu.html.twig', [
            'actu' => $actu,
        ]);
    }

       #[Route('/news/family/{family}', name: 'app_actu_family')]
    public function actufam(Family $family,FamilyRepository $repo, ActuRepository $repository, Request $request,PaginatorInterface $paginator, ): Response
    {
        $families = $repo->findAll();
       $actu = $repository->findBy([
           'family' => $family,

           'isPublished' => true,
           ],
           ['createdAt' => 'DESC']

       );
        $pagination = $paginator->paginate($actu, $request->query->getInt('page',1),
            9
        );

        return $this->render('news/actus.html.twig', [
            'actus' => $pagination,
            'family' => $family,
            'families' => $families,

        ]);
    }
    #[Route('/news/video', name: 'app_actu_video')]
    public function actuVid(FamilyRepository $repo, ActuRepository $repository, Request $request,PaginatorInterface $paginator, ): Response
    {
        $families = $repo->findAll();
/*
        $actu = $repository->findBy([
            'isVideo' => true,

            'isPublished' => true,
        ],
            ['createdAt' => 'DESC']

        );*/
        $actu = $repository->findByLink(

        );
        $pagination = $paginator->paginate($actu, $request->query->getInt('page',1),
            9
        );

        return $this->render('news/actus.html.twig', [
            'actus' => $pagination,
            'family' => 'Video',
            'families' => $families,

        ]);
    }


}
