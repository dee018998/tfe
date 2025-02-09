<?php

namespace App\Controller\Admin;

use App\Entity\Course;
use App\Form\CourseFormType;
use Knp\Component\Pager\PaginatorInterface;
use App\Repository\CourseRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\String\Slugger\SluggerInterface;

class AdminCourseController extends AbstractController
{
    public function __construct(private readonly SluggerInterface $slugger) {
    }
    #[Route('/admin/course', name: 'app_admin_course')]
    #[IsGranted('ROLE_ADMIN')]
    public function courses(CourseRepository $repository, PaginatorInterface $paginator,Request $request): Response
    {
        $data = $repository->findBy(
            [],
            ['createdAt' => 'DESC'],
        );

        $courses = $paginator->paginate($data,
            $request->query->getInt('page',1),
            12
        );
        // dump($posts);
        return $this->render('admin/course.html.twig', [
            'courses' => $courses,
        ]);
    }
    #[Route('/admin/newcourse', name: 'app_admin_newcourse')]
    #[IsGranted('ROLE_ADMIN')]
    public function newCourse(Request $request, EntityManagerInterface $manager): Response
    {
        $course = new Course();
        $form = $this->createForm(CourseFormType::class, $course,[
            'is_new'=> true
        ]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
     /*     dd($form->get('programFile')->getData()->getClientOriginalName());*/
            $course->setPublished(1);
            $slug = $this->slugger->slug($course->getName());
         /*   dd($slug);*/
            $course->setSlug($slug)
                    ->setCreatedAt(new \DateTimeImmutable());
/*            $file = $form->get('programFile')->getData();

            dd($file['OriginalName']);
            $filename = $slug .  '.' . $file->getClientOriginalExtension();

            $file->move($this->getParameter('kernel.project_dir').'/assets/images/programs' , $filename);
            $course->setProgram($filename);*/
            $manager->persist($course);
            $manager->flush();
            $this->addFlash(
                'success',
                'Le cours a été ajouté'
            );
            return $this->redirectToRoute('app_admin_course');
        }
        return $this->render('admin/newcourse.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/admin/editcourse/{id}', 'app_admin_editcourse')]
    #[IsGranted('ROLE_ADMIN')]
    public function editCourse(Course $course, Request $request, EntityManagerInterface $manager): Response
    {
        $form = $this->createForm(CourseFormType::class, $course);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $course->setUpdatedAt(new \DateTimeImmutable())
                    ->setSlug($this->slugger->slug($course->getName()));
            $manager->persist($course);
            $manager->flush();
            $this->addFlash(
                'success',
                'Le cours a été mise à jour'
            );
            return $this->redirectToRoute('app_admin_course');
        }
        return $this->render('admin/editcourse.html.twig', [
            'form' => $form,
        ]);
    }
    #[Route('/admin/viewcourse/{id}', 'app_admin_viewcourse')]
    #[IsGranted('ROLE_ADMIN')]
    public function viewCourse(Course $course, Request $request, EntityManagerInterface $manager): Response
    {

        $course->setPublished(!$course->isPublished());
        $manager->persist($course);
        $manager->flush();
        return $this->redirectToRoute('app_admin_course');

    }

    #[Route('/admin/delcourse/{id}', name: 'app_admin_delcourse')]
    #[IsGranted('ROLE_ADMIN')]
    public function delCourse(EntityManagerInterface $manager, Course $course): Response
    {
        $manager->remove($course);
        $manager->flush();
        $this->addFlash(
        'success',
        'Le cours a été supprimé'
    );
        return $this->redirectToRoute('app_admin_course');
    }


}
