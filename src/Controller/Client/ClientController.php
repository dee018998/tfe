<?php

namespace App\Controller\Client;

use App\Repository\CourseRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ClientController extends AbstractController
{
    #[Route('/client', name: 'app_client')]
    public function index(CourseRepository $repository): Response
    {
        $user = $this->getUser();
        $clientcourses = $user->getCourse();

        return $this->render('client/dashboard.html.twig', [
            'courses' => $clientcourses,
        ]);
    }

    #[Route('/client/course/{slug}', name: 'app_client_course')]
    public function clientCourse(CourseRepository $repository, $slug): Response
    {
        $user = $this->getUser();
        $clientcourses = $user->getCourse();
        foreach ($clientcourses  as $course ){
            if ($course->getslug() == $slug){
                $clientcourse = $course;
            }
        }

        return $this->render('client/course.html.twig', [
            'course' => $clientcourse,
        ]);
    }
}
