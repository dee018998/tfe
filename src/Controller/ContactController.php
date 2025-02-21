<?php

namespace App\Controller;

use App\Class\Contact;
use App\Form\ContactFormType;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Attribute\Route;

class ContactController extends AbstractController
{
    /**
     * @throws TransportExceptionInterface
     */
    #[Route('/contact', name: 'app_contact')]
    public function contact(UserRepository $repository,MailerInterface $mailer, Request $request): Response
    {
$user = [];
$admins = $repository->findPersonByRolesAdmin();
foreach ($admins as $item){
    $user[] = ($item->getEmail());

    }

/*        $email = (new Email())
            ->from('johndoe@gmail.com.com')
            ->to('info@webarticle.com')
            ->subject('Question')
            ->text('something...');
        $mailer->send($email);
        return $this->render('contact/contact.html.twig');*/

        $contact = new Contact();
        $form = $this->createForm(ContactFormType::class, $contact);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $email = (new Email())
                ->from($contact->getEmail())
                ->to($contact->getAdmin()->getEmail())
                ->subject($contact->getSubject())
                ->text($contact->getMessage());
            $mailer->send($email);
            return $this->redirectToRoute('app_home');
        }
        $this->addFlash('success', 'Your message has been sent successfully');
        return $this->render('contact/contact.html.twig', [
            'form' => $form,
        ]);

    }
}
