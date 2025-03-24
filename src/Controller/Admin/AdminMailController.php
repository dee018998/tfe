<?php

namespace App\Controller\Admin;

use App\DTO\MailDTO;
use App\Form\MailFormType;
use App\Form\MailUserFormType;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Attribute\Route;

final class AdminMailController extends AbstractController
{
    #[Route('/admin/mail', name: 'app_admin_mail')]
    public function mail(MailerInterface $mailer, Request $request): Response
    {
        $mail = new MailDTO();
        $form = $this->createForm(MailFormType::class, $mail);
        $form->handleRequest($request);
      /* dd($mail);*/
        if ($form->isSubmitted() && $form->isValid()) {
            $email = (new Email())
                ->from('message@my.online.dj.school.com')
                ->to($mail->getUser()->getEmail())
                ->subject($mail->getSubject())
                ->text($mail->getMessage());
            $mailer->send($email);
            $this->addFlash('success', 'Your message has been sent successfully');
            return $this->redirectToRoute('app_home');
        }

        return $this->render('admin/mail.html.twig', [
            'form' => $form,
        ]);
    }
    #[Route('/admin/mail/user/{id}', name: 'app_admin_mail_user')]
    public function mailUser(MailerInterface $mailer, Request $request,UserRepository $repository, $id): Response
    {
        $mail = new MailDTO();
        $form = $this->createForm(MailUserFormType::class, $mail);
        $form->handleRequest($request);
        $user = $repository->findOneBy(['id'=>$id])->getEmail();
      /* dd($mail);*/
        if ($form->isSubmitted() && $form->isValid()) {
            $email = (new Email())
                ->from('message@my.online.dj.school.com')
                ->to($user)
                ->subject($mail->getSubject())
                ->text($mail->getMessage());
            $mailer->send($email);
            $this->addFlash('success', 'Your message has been sent successfully');
            return $this->redirectToRoute('app_admin_user');
        }

        return $this->render('admin/form_template.html.twig', [
            'form' => $form,
        ]);
    }
}
