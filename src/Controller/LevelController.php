<?php

namespace App\Controller;

use App\Repository\LevelRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class LevelController extends AbstractController
{

    public function levels(LevelRepository $repository): Response
    {
        $levels = $repository->findBy(
            [],
            ['name' => 'ASC'],
        );

        return $this->render('partials/levels.html.twig', [
            'levels' => $levels,
        ]);
    }
    public function navlev(LevelRepository $repository): Response
    {
        $levels = $repository->findBy(
            [],
            ['id' => 'ASC'],
        );

        return $this->render('partials/navmodal/navtabs.html.twig', [
            'items' => $levels,
        ]);
    }

    public function navcardlev(LevelRepository $repository): Response
    {
        $levels = $repository->findBy(
            [],
            ['id' => 'ASC'],
        );

        return $this->render('partials/navmodal/navcardtabs.html.twig', [
            'items' => $levels,
        ]);
    }



}
