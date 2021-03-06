<?php

namespace EloBoostBundle\Repository;

/**
 * NotificationRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class NotificationRepository extends \Doctrine\ORM\EntityRepository
{
    public function findLast10(){
        $em = $this->getEntityManager();
        $query = $em->createQuery('SELECT N FROM EloBoostBundle:Notification N ORDER BY N.id DESC ');
        return $query->setMaxResults(10)->getResult();
    }
    public function findLast5(){
        $em = $this->getEntityManager();
        $query = $em->createQuery('SELECT N FROM EloBoostBundle:Notification N ORDER BY N.id DESC ');
        return $query->setMaxResults(5)->getResult();
    }
}
