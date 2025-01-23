<?php

namespace App\Controller;

use App\Entity\Actu;

use App\Entity\Family;
use App\Repository\ActuRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ActuController extends AbstractController
{
    #[Route('/news', name: 'app_actus')]
    public function actus(ActuRepository $repository, Request $request, PaginatorInterface $paginator): Response
    {
        $actus = $repository->findBy(
            ['isPublished' => true],
            ['createdAt' => 'DESC'],
        );
        $actus = $paginator->paginate($actus,
            $request->query->getInt('page',1),
            9
        );

        return $this->render('news/actus.html.twig',['actus'=>$actus]
        );
    }
    #[Route('/news/{slug}', name: 'app_actu')]
    public function actu(Actu $actu, ActuRepository $repository,string $slug): Response
    {
        $actu = $repository->findOneBy(['slug' => $slug]);
        return $this->render('news/actu.html.twig', [
            'actu' => $actu,
        ]);
    }

        #[Route('/news/family/{family}', name: 'app_actu_family')]
    public function actufam(Family $family, ActuRepository $repository, Request $request,PaginatorInterface $paginator): Response
    {
       $actu = $repository->findBy([
           'family' => $family,
           'isPublished' => true,
           ],
           ['createdAt' => 'DESC'],
       );
        $pagination = $paginator->paginate($actu, $request->query->getInt('page',1),
            9
        );

        return $this->render('news/actus.html.twig', [
            'actus' => $pagination,
        ]);
    }
}
