<?php

namespace App\EventListener;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\Security\Core\Event\AuthenticationSuccessEvent;

final class UserLoginListener
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    #[AsEventListener(event: 'security.authentication.success')]
    public function onSecurityAuthenticationSuccess(AuthenticationSuccessEvent $event): void
    {
        $user = $event->getAuthenticationToken()->getUser();

        if ($user) {
            $user->setLastLogAt(new \DateTimeImmutable());
            $this->entityManager->persist($user);
            $this->entityManager->flush();
        }


    }
}
