<?php

namespace App\Controller;

use App\Entity\Mailing;
use App\Form\MailingType;
use App\Repository\MailingRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class MailingController extends AbstractController
{
    #[Route('/mailing', name: 'app_mailing')]
    public function footMailing(Request $request, EntityManagerInterface $manager,MailingRepository $repo): Response
    {
/*        dd('we are');*/


        $mailing = new Mailing();
        $form = $this->createForm(MailingType::class, $mailing,[
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if (!( $repo->findOneBy(  ['email' => $form->getData()->getEmail()] ))){
              $mailing->setAsMsg(true);
                $manager->persist($mailing);
                $manager->flush();
                $this->addFlash(
                    'success',
                    'You are in our mailing list, check your email for a welcome gift'
                );
                return $this->redirectToRoute('app_home');
            }else{
                $this->addFlash(
                    'danger',
                    'Your email is in our mailing list already.'
                );
                return $this->redirectToRoute('app_home');
            }


        }
        return $this->render('mailing/form.html.twig', [
            'form' => $form]);
    }
}
