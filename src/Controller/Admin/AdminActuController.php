<?php

namespace App\Controller\Admin;

use App\Entity\Actu;
use App\Form\ActuFormType;
use App\Repository\ActuRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class AdminActuController extends AbstractController
{
    public function __construct(private readonly SluggerInterface $slugger) {
    }
    #[Route('/admin/actus', name: 'app_admin_actus')]
    public function actus(ActuRepository $repository,Request $request,PaginatorInterface $paginator): Response
    {
        $actus = $repository->findBy(
            [],
            ['createdAt'=>'Desc']);

        $actus = $paginator->paginate($actus,
            $request->query->getInt('page',1),
            12
        );
        // dump($posts);
        return $this->render('admin/actus.html.twig', [
            'actus' => $actus,
        ]);


    }

    #[Route('/admin/newactu', name: 'app_admin_newactu')]
    public function newActu(Request $request, EntityManagerInterface $manager): Response
    {
        $actu = new Actu();
        $form = $this->createForm(ActuFormType::class, $actu , [
            'is_new'=> true
        ]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            $actu->setPublished(true)
                ->setSlug($this->slugger->slug($actu->getName()))
                ->setCreatedAt(new \DateTimeImmutable());
            $manager->persist($actu);
            $manager->flush();
            $this->addFlash(
                'success',
                'La formation a été ajouté'
            );
            return $this->redirectToRoute('app_admin_actus');
        }
        return $this->render('admin/newactu.html.twig', [
            'form' => $form,
        ]);
    }
    #[Route('/admin/delactu/{id}', 'app_admin_delactu')]
    public function  delActu(EntityManagerInterface $manager, Actu $actu)
    {
        $manager->remove($actu);
        $manager->flush();
        $this->addFlash(
            'success',
            'La formation a été supprimée'
        );
        return $this->redirectToRoute('app_admin_actus');
    }

    #[Route('/admin/editactu/{id}','app_admin_editactu' )]
public function editActu(Actu $actu, Request $request, EntityManagerInterface $manager): Response
    {
       $form = $this->createForm(ActuFormType::class, $actu);
       $form->handleRequest($request);
       if($form->isSubmitted() && $form->isValid()){
          /* dd($form->getData());*/

           $actu->setSlug($this->slugger->slug($actu->getName()))
                ->setUpdatedAt(new \DateTimeImmutable());
           $manager->flush();
           $this->addFlash(
               'success',
               'La formation a été mise à jour'
           );
           return $this->redirectToRoute('app_admin_actus');
       }
       return $this->render('admin/editactu.html.twig',[
           'form'=> $form,
       ]);
    }
    #[Route('/admin/viewactu/{id}', 'app_admin_viewactu')]
    public function viewActu(Actu $actu, Request $request, EntityManagerInterface $manager): Response
    {

        $actu->setPublished(!$actu->isPublished())
            ->setSlug($this->slugger->slug($actu->getName()));
        $manager->persist($actu);
        $manager->persist($actu);
        $manager->flush();

        return $this->redirectToRoute('app_admin_actus');

    }


}
