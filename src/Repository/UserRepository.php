<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;

/**
 * @extends ServiceEntityRepository<User>
 *
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit =null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository implements PasswordUpgraderInterface
{
    public function __construct(ManagerRegistry $registry,
                                private readonly CurrencyRepository $currencyRepository)
    {
        parent::__construct($registry, User::class);
    }

	public function save( User $user): void {
		$this->getEntityManager()->persist($user);
		$this->getEntityManager()->flush();
	}

    /**
     * Used to upgrade (rehash) the user's password automatically over time.
     */
    public function upgradePassword(PasswordAuthenticatedUserInterface $user, string $newHashedPassword): void
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', $user::class));
        }

        $user->setPassword($newHashedPassword);
		$this->save($user);
    }

	public function createUser($data): User {
		$user = new User();
		$user->setEmail($data->getEmail());
		$user->setPhone($data->getPhone());
		$user->setCreatedAt();
		$user->setUpdatedAt();
		$user->setPassword(trim($data->getPassword()));
	//	dd($user->getPassword());//"$2y$13$IIGxbB1WquAk5XofhEGS3uhJ4lhzUXcnZLlFjRV1kZXd4nzePsaBm"

		$currency = $this->currencyRepository->find($this->currencyRepository::USD_ISO_CODE);
		$user->setCurrency($currency);
		$this->save($user);
		return $user;
	}

	public function updatePersonalInfo($data, User $user): void {
		$user->setUpdatedAt();
		$user->setPhone(trim($data->getPhone()));
		$user->setFirstName(trim($data->getFirstName()));
		$user->setLastName(trim($data->getLastName()));

		$currency = $this->currencyRepository->find($data->getCurrency()->getIsoCode());
		$user->setCurrency($currency);
		$this->save($user);
	}

    //    /**
    //     * @return User[] Returns an array of User objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('u')
    //            ->andWhere('u.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('u.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?User
    //    {
    //        return $this->createQueryBuilder('u')
    //            ->andWhere('u.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
