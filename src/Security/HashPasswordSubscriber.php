<?php
/**
 * User: smerteliko
 * Date: 23.05.2024
 * Time: 10:38
 */

namespace App\Security;

use App\Entity\User;
use Doctrine\Common\EventSubscriber;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

final class HashPasswordSubscriber implements EventSubscriber{
	private $passwordHasher;

	public function __construct(UserPasswordHasherInterface $passwordHasher)
	{
		$this->passwordHasher = $passwordHasher;
	}

	public function prePersist(LifecycleEventArgs $args): void
	{
		$entity = $args->getObject();
		if (! $entity instanceof User) {
			return;
		}

		$this->encodePassword($entity);
	}

	/**
	 * {@inheritdoc}
	 */
	public function getSubscribedEvents(): array {
		return ['prePersist'];
	}

	private function encodePassword(User $entity): void
	{
		$plainPassword = $entity->getPassword();
		if ($plainPassword === null) {
			return;
		}

		$encoded = $this->passwordHasher->hashPassword(
			$entity,
			$plainPassword
		);

		$entity->setPassword($encoded);
	}
}