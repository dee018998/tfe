<?php

namespace App\Controller\Admin;

use App\Repository\CourseRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AdminInscriptionController extends AbstractController
{
    #[Route('/admin/inscription', name: 'app_admin_inscription')]
    public function inscription(CourseRepository $repository, PaginatorInterface $paginator,Request $request): Response
    {$data = $repository->findBy(
        [],
        ['createdAt' => 'DESC'],
    );

        $courses = $paginator->paginate($data,
            $request->query->getInt('page',1),
            12
        );
        return $this->render('admin/inscription.html.twig', [

                'courses' => $courses,

        ]);
    }
}
