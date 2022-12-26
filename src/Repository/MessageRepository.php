<?php

namespace App\Repository;

use App\Entity\Trick;
use App\Entity\Message;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<Message>
 *
 * @method Message|null find($id, $lockMode = null, $lockVersion = null)
 * @method Message|null findOneBy(array $criteria, array $orderBy = null)
 * @method Message[]    findAll()
 * @method Message[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MessageRepository extends ServiceEntityRepository 
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Message::class);
    }

    public function add(Message $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Message $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }


    public function findPaginatedMessages(Trick $trick, $page = 1, $limit = 3): array
    {
        $result = [];
        
        $query = $this->createQueryBuilder('m')
            ->andWhere('m.trick = :trick')
            ->setParameter('trick', $trick)
           ->orderBy('m.id', 'DESC')
           ->setMaxResults(3)
           ->setFirstResult(($page - 1) * $limit);

        $paginator = new Paginator($query);
        $data = $paginator->getQuery()->getResult();

        
           
        //On calcule le nombre de page
        $pages = ceil($paginator->count() / $limit);

        //On remplit le tableau
        $result['data'] = $data;
        $result['pages'] = $pages;
        $result['page'] = $page;
        $result['limit'] = $limit;

       return $result;
   }


   
   
}
