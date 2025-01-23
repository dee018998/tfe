<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CategoryController extends AbstractController
{
    public function categories(CategoryRepository $repository): Response
    {
        $categories = $repository->findBy(
            [],
            ['name' => 'ASC'],
        );
        return $this->render('partials/categories.html.twig', [
            'categories' => $categories,
        ]);
    }

    public function navcat(CategoryRepository $repository): Response
    {
        $categories = $repository->findBy(
            [],
            ['id' => 'ASC'],
        );
        return $this->render('partials/navmodal/navtabs.html.twig', [
            'items' => $categories,
        ]);
    }

    public function navcardcat(CategoryRepository $repository): Response
    {
        $categories = $repository->findBy(
            [],
            ['id' => 'ASC'],
        );
        return $this->render('partials/navmodal/navcardtabs.html.twig', [
            'items' => $categories,
        ]);
    }

}
