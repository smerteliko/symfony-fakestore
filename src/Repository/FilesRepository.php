<?php
declare(strict_types=1);

namespace App\Repository;

use App\Entity\Files;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * @extends ServiceEntityRepository<Files>
 *
 * @method Files|null find($id, $lockMode = null, $lockVersion = null)
 * @method Files|null findOneBy(array $criteria, array $orderBy = null)
 * @method Files[]    findAll()
 * @method Files[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FilesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Files::class);
    }

    public function save(Files $files): void {
        $this->getEntityManager()->persist($files);
        $this->getEntityManager()->flush();
    }

    public function remove(Files $files): void {
        $this->getEntityManager()->remove($files);
        $this->getEntityManager()->flush();
    }

    public function saveNewFile(UploadedFile $file, string $fileName): Files {
        $fileEnt = new Files();
        $fileEnt->setOriginalName($file->getClientOriginalName());
        $fileEnt->setFileName($fileName);
        $fileEnt->setType($file->getMimeType());
        $fileEnt->setSize($file->getSize());
        $fileEnt->setExt($file->getClientOriginalExtension());
        $fileEnt->setCreatedAt();

        $this->save($fileEnt);
        return $fileEnt;
    }

    //    /**
    //     * @return Files[] Returns an array of Files objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('f')
    //            ->andWhere('f.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('f.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Files
    //    {
    //        return $this->createQueryBuilder('f')
    //            ->andWhere('f.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
