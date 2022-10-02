<?php

namespace App\Repository;

use App\Entity\Departement;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Departement>
 *
 * @method Departement|null find($id, $lockMode = null, $lockVersion = null)
 * @method Departement|null findOneBy(array $criteria, array $orderBy = null)
 * @method Departement[]    findAll()
 * @method Departement[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DepartementRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Departement::class);
    }

    public function add(Departement $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Departement $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    // une fonction réalisant de façon explicite une requête DQL
    public function findExplicitDepts($region): array
    {
      $qb = $this->createQueryBuilder('d')
                 ->select('d.code', 'r.nom region', 'd.nom departement')
      // ici on profite du lien réalisé au cours des exercices précédents entre 'departement' et 'region'
                 ->leftJoin('d.region', 'r')
      // mais les lignes commentées ci dessous montrent comment réaliser une jointure sur des tables non liées
      //         ->leftJoin('App\Entity\Region', 'r',
      //                    \Doctrine\ORM\Query\Expr\Join::WITH, 'r.id = d.region')
                 ->where('lower(r.nom) = lower(:region)')
                 ->setParameter('region', $region)
                 ->orderBy('d.code', 'DESC');
      //echo $qb;exit; // pour afficher la requête
      return $qb->getQuery($region)->getResult();
    }

}
//    /**
//     * @return Departement[] Returns an array of Departement objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('d')
//            ->andWhere('d.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('d.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Departement
//    {
//        return $this->createQueryBuilder('d')
//            ->andWhere('d.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }

