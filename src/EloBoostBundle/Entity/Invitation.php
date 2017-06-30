<?php
/**
 * Created by PhpStorm.
 * User: Asus
 * Date: 26/06/2017
 * Time: 15:07
 */

namespace EloBoostBundle\Entity;
use Doctrine\ORM\Mapping as ORM;

/** @ORM\Entity */
class Invitation
{
    /** @ORM\Id @ORM\Column(type="string", length=6) */
    protected $code;

    /** @ORM\Column(type="string", length=256) */
    protected $email;

    /**
     * @ORM\Column(type="string", length=256)
     */
    protected $role;

    /**
     * When sending invitation be sure to set this value to `true`
     *
     * It can prevent invitations from being sent twice
     *
     * @ORM\Column(type="boolean")
     */
    protected $sent = false;

    public function __construct()
    {
        // generate identifier only once, here a 6 characters length code
        $this->code = substr(md5(uniqid(rand(), true)), 0, 6);
    }

    /**
     * @return mixed
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * @param mixed $role
     */
    public function setRole($role)
    {
        $this->role = $role;
    }

    /**
     * @return mixed
     */
    public function getSent()
    {
        return $this->sent;
    }

    /**
     * @param mixed $sent
     */
    public function setSent($sent)
    {
        $this->sent = $sent;
    }



    public function getCode()
    {
        return $this->code;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function isSent()
    {
        return $this->sent;
    }

    public function send()
    {
        $this->sent = true;
    }
}