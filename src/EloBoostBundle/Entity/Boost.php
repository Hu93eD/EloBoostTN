<?php

namespace EloBoostBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Boost
 *
 * @ORM\Table(name="boost")
 * @ORM\Entity(repositoryClass="EloBoostBundle\Repository\BoostRepository")
 */
class Boost
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
     * @ORM\Column(name="FromLP", type="string", length=255)
     */
    private $fromLP;

    /**
     * @var string
     *
     * @ORM\Column(name="FromDiv", type="string", length=255)
     */
    private $fromDiv;

    /**
     * @var string
     *
     * @ORM\Column(name="FromLG", type="string", length=255)
     */
    private $fromLG;

    /**
     * @var string
     *
     * @ORM\Column(name="ToDiv", type="string", length=255)
     */
    private $toDiv;

    /**
     * @var string
     *
     * @ORM\Column(name="ToLG", type="string", length=255)
     */
    private $toLG;

    /**
     * @var Assert\Date $created
     *
     * @ORM\Column(name="CreatedAt", type="datetime")
     * @ORM\Version
     */
    private $createdat;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="FinishedAt", type="datetime" , nullable=true)
     */
    private $finishedAt;

    /**
     * @var string
     *
     * @ORM\Column(name="Status", type="string", length=255)
     */
    private $status;

    /**
     * @var string
     *
     * @ORM\Column(name="Booster", type="string", length=255, nullable=true)
     */
    private $booster;

    /**
     * @var string
     *
     * @ORM\Column(name="Paid", type="string", length=255)
     */
    private $paid;

    /**
     * @var string
     *
     * @ORM\Column(name="Code", type="string", length=255, unique = true)
     */
    private $code;

    /**
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="UserID",referencedColumnName="id",onDelete="CASCADE")
     */
    private $userId;

    /**
     * @return Assert\Date
     */
    public function getCreatedat()
    {
        return $this->createdat;
    }

    /**
     * @return \DateTime
     */

    public function getFinishedAt()
    {
        return $this->finishedAt;
    }

    /**
     * @param \DateTime $finishedAt
     */
    public function setFinishedAt($finishedAt)
    {
        $this->finishedAt = $finishedAt;
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
     * @return string
     */
    public function getPaid()
    {
        return $this->paid;
    }

    /**
     * @param string $paid
     */
    public function setPaid($paid)
    {
        $this->paid = $paid;
    }

    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param string $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * @return string
     */
    public function getBooster()
    {
        return $this->booster;
    }

    /**
     * @param string $booster
     */
    public function setBooster($booster)
    {
        $this->booster = $booster;
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
     * Set fromLP
     *
     * @param string $fromLP
     *
     * @return Boost
     */
    public function setFromLP($fromLP)
    {
        $this->fromLP = $fromLP;

        return $this;
    }

    /**
     * Get fromLP
     *
     * @return string
     */
    public function getFromLP()
    {
        return $this->fromLP;
    }

    /**
     * Set fromDiv
     *
     * @param string $fromDiv
     *
     * @return Boost
     */
    public function setFromDiv($fromDiv)
    {
        $this->fromDiv = $fromDiv;

        return $this;
    }

    /**
     * Get fromDiv
     *
     * @return string
     */
    public function getFromDiv()
    {
        return $this->fromDiv;
    }

    /**
     * Set fromLG
     *
     * @param string $fromLG
     *
     * @return Boost
     */
    public function setFromLG($fromLG)
    {
        $this->fromLG = $fromLG;

        return $this;
    }

    /**
     * Get fromLG
     *
     * @return string
     */
    public function getFromLG()
    {
        return $this->fromLG;
    }

    /**
     * Set toDiv
     *
     * @param string $toDiv
     *
     * @return Boost
     */
    public function setToDiv($toDiv)
    {
        $this->toDiv = $toDiv;

        return $this;
    }

    /**
     * Get toDiv
     *
     * @return string
     */
    public function getToDiv()
    {
        return $this->toDiv;
    }

    /**
     * Set toLG
     *
     * @param string $toLG
     *
     * @return Boost
     */
    public function setToLG($toLG)
    {
        $this->toLG = $toLG;

        return $this;
    }

    /**
     * Get toLG
     *
     * @return string
     */
    public function getToLG()
    {
        return $this->toLG;
    }

    /**
     * Set userId
     *
     * @param integer $userId
     *
     * @return Boost
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;

        return $this;
    }

    /**
     * Get userId
     *
     * @return int
     */
    public function getUserId()
    {
        return $this->userId;
    }
}

