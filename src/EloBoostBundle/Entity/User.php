<?php

namespace EloBoostBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * User
 *
 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass="EloBoostBundle\Repository\UserRepository")
 */
class User
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
     * @ORM\Column(name="EmailAddress", type="string", length=255)
     */
    private $emailAddress;

    /**
     * @var string
     *
     * @ORM\Column(name="BankCC", type="string", length=255)
     */
    private $bankCC;

    /**
     * @var string
     *
     * @ORM\Column(name="PhoneNumber", type="string", length=255, nullable=true)
     */
    private $phoneNumber;


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
     * Set emailAddress
     *
     * @param string $emailAddress
     *
     * @return User
     */
    public function setEmailAddress($emailAddress)
    {
        $this->emailAddress = $emailAddress;

        return $this;
    }

    /**
     * Get emailAddress
     *
     * @return string
     */
    public function getEmailAddress()
    {
        return $this->emailAddress;
    }



    /**
     * Set bankCC
     *
     * @param string $bankCC
     *
     * @return User
     */
    public function setBankCC($bankCC)
    {
        $this->bankCC = $bankCC;

        return $this;
    }

    /**
     * Get bankCC
     *
     * @return string
     */
    public function getBankCC()
    {
        return $this->bankCC;
    }

    /**
     * Set phoneNumber
     *
     * @param string $phoneNumber
     *
     * @return User
     */
    public function setPhoneNumber($phoneNumber)
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }

    /**
     * Get phoneNumber
     *
     * @return string
     */
    public function getPhoneNumber()
    {
        return $this->phoneNumber;
    }
}

