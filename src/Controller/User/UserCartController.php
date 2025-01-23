<?php

namespace App\Controller\User;

use App\Repository\CourseRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
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
    public function userValidateCart(SessionInterface $session,EntityManagerInterface $manager): Response
    {
        $cart = $session->get('cart', []);
        $user = $this->getUser();
        $session->set('cart', []);
        foreach ($cart as $key => $id) {

            $course = $this->repository->find($id);
            $user->addCourse($course);
           $manager->persist($user);
            $manager->flush();


        }
        $this->addFlash(
            'success',
            'Votre achat a bien été éffectué'
        );
        return $this->redirectToRoute('app_courses');



    }

}
