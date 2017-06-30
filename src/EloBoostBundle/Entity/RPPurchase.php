<?php

namespace EloBoostBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * RPPurchase
 *
 * @ORM\Table(name="r_p_purchase")
 * @ORM\Entity(repositoryClass="EloBoostBundle\Repository\RPPurchaseRepository")
 */
class RPPurchase
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
     * @var int
     *
     * @ORM\Column(name="Amount", type="integer")
     */
    private $amount;

    /**
     * @var string
     *
     * @ORM\Column(name="Code", type="string", length=255, unique=true)
     */
    private $code;

    /**
     * @var Assert\Date $created
     *
     * @ORM\Column(name="CreatedAt", type="datetime", nullable=true)
     * @ORM\Version
     */
    private $createdAt;


    /**
     * @ORM\ManyToOne(targetEntity="Account")
     * @ORM\JoinColumn(name="Account",referencedColumnName="id",onDelete="SET NULL")
     */
    private $account;

    /**
     * @ORM\OneToOne(targetEntity="Payment")
     * @ORM\JoinColumn(name="Transaction",referencedColumnName="id",onDelete="CASCADE")
     */
    private $transaction;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="RedeemedAt", type="datetime" , nullable=true)
     */
    private $redeemedAt;

    /**
     * @return \DateTime
     */
    public function getRedeemedAt()
    {
        return $this->redeemedAt;
    }

    /**
     * @param \DateTime $redeemedAt
     */
    public function setRedeemedAt($redeemedAt)
    {
        $this->redeemedAt = $redeemedAt;
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
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @param string $code
     */
    public function setCode($code)
    {
        $this->code = $code;
    }



    /**
     * Set amount
     *
     * @param integer $amount
     *
     * @return RPPurchase
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * Get amount
     *
     * @return int
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return RPPurchase
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @return Account
     */
    public function getAccount()
    {
        return $this->account;
    }

    /**
     * @param mixed Account
     */
    public function setAccount($account)
    {
        $this->account = $account;
    }



    /**
     * @return Payment
     */
    public function getTransaction()
    {
        return $this->transaction;
    }

    /**
     * @param mixed Payment
     */
    public function setTransaction($transaction)
    {
        $this->transaction = $transaction;
    }

    public function __construct()
    {
        // generate identifier only once, here a 6 characters length code
        $this->code = substr(md5(uniqid(rand(), true)), 0, 6);
    }


}

