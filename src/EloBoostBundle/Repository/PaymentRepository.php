<?php

namespace EloBoostBundle\Repository;

/**
 * PaymentRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class PaymentRepository extends \Doctrine\ORM\EntityRepository
{
    //Success
    public function updatetransnumber($id,$trcode){
        $qb = $this->getEntityManager()->createQueryBuilder();
        $q = $qb->update('EloBoostBundle:Payment', 'P')
            ->set('P.transactionNumber', '?1')
            ->where('P.id = ?2')
            ->setParameter(1, $trcode)
            ->setParameter(2, $id)
            ->getQuery();
        $p = $q->execute();
    }
    //Success
    public function setseen(){
        $qb = $this->getEntityManager()->createQueryBuilder();
        $q = $qb->update('EloBoostBundle:Payment', 'P')
            ->set('P.seen', '?1')
            ->setParameter(1, true)
            ->getQuery();
        $p = $q->execute();
    }
    //SUCESS
    public function countunseen(){

        return $this->getEntityManager()
            ->createQuery("SELECT COUNT (p) FROM EloBoostBundle:Payment p WHERE p.seen=0") ->getOneOrNullResult();
    }

}
