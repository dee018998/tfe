<?php

namespace App\Controller;

use App\Repository\ColorRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ColorController extends AbstractController
{

    public function colors( ColorRepository $repository): Response
    {
     $colors = $repository->findBy(
         [],
    ['name'=>'ASC'],
);

        return $this->render('partials/color.html.twig', [
            'colors'=> $colors
        ]);
    }
}
