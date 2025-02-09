<?php

namespace App\EventListener;

use AllowDynamicProperties;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Core\Event\AuthenticationSuccessEvent;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\HttpFoundation\Response;
#[AllowDynamicProperties] final class UserLoginListener
{
    private $router;

    public function __construct(UrlGeneratorInterface $router,EntityManagerInterface $entityManager)
    {
        $this->router = $router;
        $this->entityManager = $entityManager;
    }


    #[AsEventListener(event: 'security.authentication.success')]
    public function onSecurityAuthenticationSuccess(AuthenticationSuccessEvent $event)
    {


        $user = $event->getAuthenticationToken()->getUser();
        $role = $user->getRoles();
        if (in_array("ROLE_SUPER_ADMIN", $role)){
            return new RedirectResponse($this->router->generate('app_admin_course'));
        }
        if ($user) {
            $user->setLastLogAt(new \DateTimeImmutable());
            $this->entityManager->persist($user);
            $this->entityManager->flush();
        }


    }
}
