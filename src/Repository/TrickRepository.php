<?php

namespace App\Repository;

use App\Entity\Trick;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Trick>
 *
 * @method Trick|null find($id, $lockMode = null, $lockVersion = null)
 * @method Trick|null findOneBy(array $criteria, array $orderBy = null)
 * @method Trick[]    findAll()
 * @method Trick[]    findBy(array $criteria, array $orderBy = desc, $limit = null, $offset = null)
 */
class TrickRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry) 
    {
        parent::__construct($registry, Trick::class);
    }

    public function add(Trick $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Trick $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
    
     /**
     * @return Trick[] Returns an array of Trick objects
     */
    public function findByLimit(bool $full = false, int $page, int $limit = 8){

        if($full > 0){
            return $this->createQueryBuilder('t')
                    ->setFirstResult(($page - 1) * $limit)
                    ->orderBy('t.id', 'DESC')
                    ->getQuery()
                    ->getResult();
        }else{
            return $this->createQueryBuilder('t')
                    ->setFirstResult(($page - 1) * $limit)
                    ->orderBy('t.id', 'DESC')
                    ->setMaxResults(8)
                    ->getQuery()
                    ->getResult();
        }

        
    }





}
