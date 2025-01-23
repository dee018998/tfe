<?php

namespace App\Controller;

use App\Entity\Actu;
use App\Form\ActuType;
use App\Repository\ActuRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/test/actu/controler')]
final class TestActuControlerController extends AbstractController{
    #[Route(name: 'app_test_actu_controler_index', methods: ['GET'])]
    public function index(ActuRepository $actuRepository): Response
    {
        return $this->render('test_actu_controler/index.html.twig', [
            'actus' => $actuRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_test_actu_controler_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $actu = new Actu();
        $form = $this->createForm(ActuType::class, $actu);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($actu);
            $entityManager->flush();

            return $this->redirectToRoute('app_test_actu_controler_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('test_actu_controler/new.html.twig', [
            'actu' => $actu,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_test_actu_controler_show', methods: ['GET'])]
    public function show(Actu $actu): Response
    {
        return $this->render('test_actu_controler/show.html.twig', [
            'actu' => $actu,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_test_actu_controler_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Actu $actu, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ActuType::class, $actu);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_test_actu_controler_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('test_actu_controler/edit.html.twig', [
            'actu' => $actu,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_test_actu_controler_delete', methods: ['POST'])]
    public function delete(Request $request, Actu $actu, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$actu->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($actu);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_test_actu_controler_index', [], Response::HTTP_SEE_OTHER);
    }
}
