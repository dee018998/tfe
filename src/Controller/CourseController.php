<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Form\CommentFormType;
use App\Repository\CourseRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;


class CourseController extends AbstractController
{
    #[Route('/courses', name: 'app_courses')]
public function courses(CourseRepository $repository, Request $request,PaginatorInterface $paginator,): Response
{

    $courses = $repository->findBy(

        ['isPublished' => true],
        ['createdAt' => 'DESC']
    );
    $courses = $paginator->paginate($courses, $request->query->getInt('page',1),8);
    return $this->render('course/courses.html.twig', [
        'courses' => $courses,
    ]);
}


    #[Route('/course/{slug}', 'app_course')]
    public function course(Request $request, CourseRepository $repository, EntityManagerInterface $manager, string $slug): Response
    {

        $course = $repository->findOneBy(['slug'=>$slug]);

      $comment = new Comment();
        $form = $this->createForm(CommentFormType::class, $comment);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            $comment->setCreatedAt(new \DateTimeImmutable())
                ->setUser($this->getUser())
                ->setCourse($course)
                ->setPublished(True)
                ->setModarated(False);
            $manager->persist($comment);
            $manager->flush();
            $this->addFlash(
                'success',
                'Votre commentaire a bien été enregistré'
            );
            return $this->redirectToRoute('app_courses');
        }


        return $this->render('course/course.html.twig', [
            'course' => $course,
         /*   'form'=>$form*/
        ]);


    }

    #[Route('/courses/category/{category}', name: 'app_courses_category')]
    public function courseCat($category, CourseRepository $repository, Request $request, PaginatorInterface $paginator): Response
    {
/*dd($category);*/
        $courses = $repository->findBy([
            'category' => $category,
            'isPublished' => true,],
            ['createdAt' => 'DESC'],
        );


        $pagination = $paginator->paginate($courses, $request->query->getInt('page',1),8);

        return $this->render('course/courses.html.twig', [
            'courses' => $pagination,
        ]);
    }

    #[Route('/courses/level/{level}',  name: 'app_courses_level')]
    public function courseLev($level, CourseRepository $repository,Request $request,PaginatorInterface $paginator ): Response
    {
       /*dd($level);*/
        $courses = $repository->findBy([
                'level' => $level,
                'isPublished' => true,],
            ['createdAt' => 'DESC'],
        );

        $pagination = $paginator->paginate($courses, $request->query->getInt('page',1),8);

        return $this->render('course/courses.html.twig', [
            'courses' => $pagination,
        ]);
    }

    #[Route('/courses/best', name: 'app_courses_best')]
    public function courseBst(CourseRepository $repository, Request $request,PaginatorInterface $paginator,): Response
    {

        $courses = $repository->findBy(

            ['isPublished' => true],
            ['createdAt' => 'DESC'],
            3

        );

        return $this->render('partials/course/best.html.twig', [
            'courses' => $courses,
        ]);
    }

    #[Route('/courses/nav/best', name: 'app_courses_nav')]
    public function nav(CourseRepository $repository, Request $request,PaginatorInterface $paginator,): Response
    {

        $courses = $repository->findBy(

            ['isPublished' => true],
            ['createdAt' => 'DESC'],
            3

        );

        return $this->render('partials/navmodal/navcardbest.html.twig', [
            'courses' => $courses,
        ]);
    }

    #[Route('/courses/nav/category/{category}', name: 'app_courses_nav_category')]
    public function navcat($category, CourseRepository $repository, Request $request,): Response
    {

        $courses = $repository->findBy([
            'category' => $category,
            'isPublished' => true,],
            ['createdAt' => 'DESC'],
            12
        );


        return $this->render('course/navcourses.html.twig', [
            'courses' => $courses,
        ]);
    }

}
