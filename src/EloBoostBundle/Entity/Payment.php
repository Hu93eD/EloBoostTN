<?php

namespace EloBoostBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Payment
 *
 * @ORM\Table(name="payment")
 * @ORM\Entity(repositoryClass="EloBoostBundle\Repository\PaymentRepository")
 */
class Payment
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="TransactionNumber", type="string", length=255, nullable=true, unique=true)
     */
    private $transactionNumber;

    /**
     * @var bool
     *
     * @ORM\Column(name="Status", type="boolean", options={"default"=false} , nullable=true)
     */
    private $status;

    /**
     * @var bool
     *
     * @ORM\Column(name="Seen", type="boolean" )
     */
    private $seen = false;

    /**
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="UserID",referencedColumnName="id",onDelete="SET NULL")
     */
    private $userId;

    /**
     * @ORM\ManyToOne(targetEntity="Boost")
     * @ORM\JoinColumn(name="BoostID",referencedColumnName="id",onDelete="SET NULL")
     */
    private $boost;

    /**
     * @ORM\ManyToOne(targetEntity="RPPurchase")
     * @ORM\JoinColumn(name="RPID",referencedColumnName="id",onDelete="SET NULL")
     */
    private $RP;

    /**
     * @var bool
     *
     * @ORM\Column(name="Archived", type="boolean" )
     */
    private $archived = false;

    /**
     * @return boolean
     */
    public function isArchived()
    {
        return $this->archived;
    }

    /**
     * @param boolean $archived
     */
    public function setArchived($archived)
    {
        $this->archived = $archived;
    }

    /**
     * @return RPPurchase
     */
    public function getRP()
    {
        return $this->RP;
    }

    /**
     * @param RPPurchase $RP
     */
    public function setRP($RP)
    {
        $this->RP = $RP;
    }




    /**
     * @return mixed
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * @param mixed $userId
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;
    }

    /**
     * @return mixed
     */
    public function getBoost()
    {
        return $this->boost;
    }

    /**
     * @param mixed $boost
     */
    public function setBoost($boost)
    {
        $this->boost = $boost;
    }

    /**
     * @return mixed
     */
    public function getSeen()
    {
        return $this->seen;
    }

    /**
     * @param mixed $seen
     */
    public function setSeen($seen)
    {
        $this->seen = $seen;
    }



    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set transactionNumber
     *
     * @param string $transactionNumber
     *
     * @return Payment
     */
    public function setTransactionNumber($transactionNumber)
    {
        $this->transactionNumber = $transactionNumber;

        return $this;
    }

    /**
     * Get transactionNumber
     *
     * @return string
     */
    public function getTransactionNumber()
    {
        return $this->transactionNumber;
    }

    /**
     * Set status
     *
     * @param boolean $status
     *
     * @return Payment
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return bool
     */
    public function getStatus()
    {
        return $this->status;
    }

    function __toString()
    {
        return $this->getId().' ; '.$this->getBoost().' ; '.$this->getUserId().' ; ';
    }

}

