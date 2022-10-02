<?php
 
namespace App\Repository;
 
use App\Entity\Ville;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
 
/**
 * @extends ServiceEntityRepository<Ville>
 *
 * @method Ville|null find($id, $lockMode = null, $lockVersion = null)
 * @method Ville|null findOneBy(array $criteria, array $orderBy = null)
 * @method Ville[]    findAll()
 * @method Ville[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VilleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Ville::class);
    }
 
    public function add(Ville $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);
 
        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
 
    public function remove(Ville $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);
 
        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
 
    /**
     * @return Ville[] Returns an array of Ville objects
     */
    public function findMinMax(string $col, int $min, int $max, string $order): array
    {
      $qb = $this->createQueryBuilder('p')->where("p.$col > :min AND p.$col < :max");
      if (strtolower($order) == 'asc') {
        $qb->orderBy("p.$col", 'ASC');
      } else {
        $qb->orderBy("p.$col", 'DESC');
      }
      $query = $qb->getQuery();
      $query->setParameter('max', $max)->setParameter('min', $min);
      $results = $query->getResult();
      return $results;
    }
 
  //    /**
//     * @return Ville[] Returns an array of Ville objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('v')
//            ->andWhere('v.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('v.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }
 
//    public function findOneBySomeField($value): ?Ville
//    {
//        return $this->createQueryBuilder('v')
//            ->andWhere('v.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
