<?php
/**
 * Created by PhpStorm.
 * User: Asus
 * Date: 21/06/2017
 * Time: 12:23
 */

namespace EloBoostBundle\Entity;
use FOS\UserBundle\Model\User as BaseUser;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 */
class FUser extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\OneToOne(targetEntity="Invitation")
     * @ORM\JoinColumn(referencedColumnName="code",onDelete="SET NULL")
     * @Assert\NotNull(message="Your invitation is wrong", groups={"Registration"})
     */
    protected $invitation;

    public function setInvitation(Invitation $invitation)
    {
        $this->invitation = $invitation;
    }

    public function getInvitation()
    {
        return $this->invitation;
    }

    public function __construct()
    {
        parent::__construct();
        // your own logic
    }
}