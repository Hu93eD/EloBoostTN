<?php

namespace EloBoostBundle\Repository;

/**
 * BoostRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class BoostRepository extends \Doctrine\ORM\EntityRepository
{
    public function countall(){
        return $this->getEntityManager()
            ->createQuery("SELECT COUNT (p) FROM EloBoostBundle:Boost p") ->getOneOrNullResult();
    }

    public function countpaid(){
        return $this->getEntityManager()
            ->createQuery("SELECT COUNT (p) FROM EloBoostBundle:Boost p WHERE p.paid = :paid")->setParameter('paid','Yes')->getOneOrNullResult();
    }
}
