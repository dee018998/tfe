<?php

namespace App\Controller;

use App\Repository\FamilyRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class FamilyController extends AbstractController
{

    public function families(FamilyRepository $repository): Response
    {
        $families = $repository->findBy(
            [],
            ['name' => 'ASC'],
        );

        return $this->render('partials/navmodal/navtabs.html.twig', [
            'items' => $families,
        ]);
    }
    public function familiesPhone(FamilyRepository $repository): Response
    {
        $families = $repository->findBy(
            [],
            ['name' => 'ASC'],
        );

        return $this->render('partials/family.html.twig', [
            'families' => $families,
        ]);
    }
}
