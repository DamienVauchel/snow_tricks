<?php

namespace ST\AppBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="users")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\OneToOne(targetEntity="ST\AppBundle\Entity\Media", cascade={"persist", "remove"})
     */
    protected $photo;

    /**
     * Set photo
     *
     * @param \ST\AppBundle\Entity\Media $photo
     *
     * @return User
     */
    public function setPhoto(\ST\AppBundle\Entity\Media $photo = null)
    {
        $this->photo = $photo;

        return $this;
    }

    /**
     * Get photo
     *
     * @return \ST\AppBundle\Entity\Media
     */
    public function getPhoto()
    {
        return $this->photo;
    }
}
