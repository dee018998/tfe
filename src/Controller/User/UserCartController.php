<?php

namespace App\Controller\User;

use App\Repository\CourseRepository;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectManager;

class UserCartController extends AbstractController
{
    public function __construct(private readonly CourseRepository $repository)
    {

    }

    #[Route('/user/cart/', name: 'app_user_cart')]
    public function userCart(SessionInterface $session,): Response
    {
        $cart = $session->get('cart', []);
        if (!$cart){
            $this->addFlash(
                'danger',
                'Votre panier est vide');
            return $this->redirectToRoute('app_home');
        }
        $cartWithData = [];
        foreach ($cart as $key => $id) {
            $cartWithData[] = [
                'course' => $this->repository->find($id)
            ];
        }
        /*dd($cartWithData);*/
        $total = array_sum(array_map(function ($item) {
            return $item['course']->getPrice();
        }, $cartWithData));
        return $this->render('user/cart.html.twig', [
            'items' => $cartWithData,
            'total' => $total
        ]);
    }

    #[Route('/user/cart/addcoursetocart/{id}', name: 'app_cart_addcourse')]
    public function userAddCourse(int $id, SessionInterface $session,): Response
    {
        $cart = $session->get('cart', []);
$course = $this->getUser()->getCourse();
foreach ($course as $item) {
/*    dump($id);
    dump($item);*/
    if ($id == $item->getId()) {
        $this->addFlash(
            'danger',
            'You already own this course');
        return $this->redirectToRoute('app_courses');

    }
}

        if (in_array($id, $cart)) {
            $this->addFlash(
                'danger',
                'Votre avez déja sélectionné ce cours');
            return $this->redirectToRoute('app_courses');

        } else {
            $cart[] = $id;
            $session->set('cart', $cart);
            $this->addFlash(
                'success',
                'La formation a été ajouté à votre panier');
            return $this->redirectToRoute('app_courses');
        }
    }

    #[Route('/user/cart/delcoursefromcart/{id}', name: 'app_cart_delcourse')]
    public function userDelCourse(int $id, SessionInterface $session,): Response
    {
    /* foreach ($cart as $i => $value ){
        if ($id == $value){
         unset($cart[$i]);
        }

    }*/
        /*PLUS EFFICACE*/
        $cart = $session->get('cart', [$id]);
        $cart = array_diff($cart, [$id]);
        $session->set('cart', $cart);
        return $this->redirectToRoute('app_user_cart');

    }

    #[Route('/user/cart/deletecart', name: 'app_cart_delete')]
    public function userRemCart(SessionInterface $session,): Response
    {
        $session->set('cart', []);
        $this->addFlash(
            'success',
            'Votre panier a été vidé');
        return $this->redirectToRoute('app_courses');
    }
    #[Route('/user/cart/validate', name: 'app_cart_validate')]
    public function userValidateCart(SessionInterface $session,EntityManagerInterface $manager, MailerInterface $mailer): Response
    {
        $cart = $session->get('cart', []);
        $cartWithData = [];
        $user = $this->getUser();
       /* $session->set('cart', []);*/
        foreach ($cart as $key => $id) {

            $course = $this->repository->find($id);
         /*   $user->addCourse($course);*/
          /*  $course->addUser($user);*/

      /*     $manager->persist($course);*/


          /*  $manager->persist($user);
            $manager->flush();*/
            $cartWithData[] = [
                'course' => $course
            ];
        }
/*        dd($cartWithData);*/
        $total = array_sum(array_map(function ($item) {
            return $item['course']->getPrice();
        }, $cartWithData));
        /*TO DUMP & VIEW MAIL*/
/*        return $this->render('user/template_email/user_order_email.html.twig', [
            'items' => $cartWithData,
            'total' => $total
        ]);*/
        /*eeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeee*/

        $email = (new TemplatedEmail())
        ->from("my.on.line.dj.school@gmail.com")
        ->to($user->getUserIdentifier())
        ->subject('Order confirmation')
        ->htmlTemplate('user/template_email/user_order_email.html.twig')
        // pass variables (name => value) to the template
        ->context([
            'expiration_date' => new \DateTime('+7 days'),
            'items' => $cartWithData,
            'total' => $total
        ]);

        $mailer->send($email);
        $this->addFlash(
            'success',
            'Votre achat a bien été éffectué'
        );
        return $this->redirectToRoute('app_home');



    }

}
