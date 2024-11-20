<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\User;
use App\Entity\UserImages;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<UserImages>
 *
 * @method UserImages|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserImages|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserImages[]    findAll()
 * @method UserImages[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserImagesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry,
        private readonly UserRepository $userRepository,
        private readonly FilesRepository $filesRepository)
    {
        parent::__construct($registry, UserImages::class);
    }

    public function save(UserImages $userImages): void
    {
        $this->getEntityManager()->persist($userImages);
        $this->getEntityManager()->flush();
    }

    public function updateOrSetNewAvatar(?User $user,$data = []): void
    {
        $file = $this->filesRepository->findOneBy(['id' => $data['FileID']]);
        $userImages = [];
        if ($user?->getUserImages()) {
            $userImages = $this->find($user?->getUserImages()?->getID());
            $userImages->setImageFile($file);
        } else {
            $userImages = new UserImages();
            $userImages->setImageUser($user);
            $userImages->setImageFile($file);
            $userImages->setCreatedAt();
        }
        $userImages->setUpdatedAt();

        $this->save($userImages);
    }

    //    /**
    //     * @return UserImages[] Returns an array of UserImages objects
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

    //    public function findOneBySomeField($value): ?UserImages
    //    {
    //        return $this->createQueryBuilder('u')
    //            ->andWhere('u.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
