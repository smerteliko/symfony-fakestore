<?php
/**
 * User: smerteliko
 * Date: 23.05.2024
 * Time: 10:38.
 */

declare(strict_types=1);

namespace App\Event\Security;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsDoctrineListener;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[AsDoctrineListener('prePersist')]
final class HashPasswordSubscriber
{
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function prePersist(LifecycleEventArgs $args): void
    {
        $entity = $args->getObject();
        if (!$entity instanceof User) {
            return;
        }
        $this->encodePassword($entity);
    }

    public function getSubscribedEvents(): array
    {
        return ['prePersist'];
    }

    private function encodePassword(User $entity): void
    {
        $plainPassword = $entity->getPassword();
        if (null === $plainPassword) {
            return;
        }

        $encoded = $this->passwordHasher->hashPassword(
            $entity,
            $plainPassword
        );

        $entity->setPassword($encoded);
    }
}
