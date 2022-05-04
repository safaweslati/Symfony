<?php

namespace App\Repository;

use App\Entity\Personne;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Personne>
 *
 * @method Personne|null find($id, $lockMode = null, $lockVersion = null)
 * @method Personne|null findOneBy(array $criteria, array $orderBy = null)
 * @method Personne[]    findAll()
 * @method Personne[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PersonneRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Personne::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Personne $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function remove(Personne $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    // /**
    //  * @return Personne[] Returns an array of Personne objects
    //  */

     private function addIntervalAge(QueryBuilder $qb,$agemin,$agemax){
        $qb->andWhere('p.age <= :agemax and p.age >= :agemin ')
            ->setParameter('agemin',$agemin)
            ->setParameter('agemax',$agemax);

     }

    public function findByAgeInterval($agemin,$agemax)
    {
        $qb=$this->createQueryBuilder('p');
        $this->addIntervalAge($qb,$agemin,$agemax);
           return $qb->orderBy('p.id', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }
    public function statByAgeInterval($agemin,$agemax)
    {
         $qb=$this->createQueryBuilder('p')
            ->select( 'avg (p.age) as ageMoyen,count(p.id) as nbPersonne')
            ->orderBy('p.id', 'ASC');
         $this->addIntervalAge($qb,$agemin,$agemax);
            return $qb->getQuery()->getScalarResult();
    }


    /*
    public function findOneBySomeField($value): ?Personne
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
