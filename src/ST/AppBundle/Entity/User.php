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
     * @ORM\OneToOne(targetEntity="ST\AppBundle\Entity\Image", cascade={"persist", "remove"})
     */
    private $image;

    /**
     * Set image
     *
     * @param \ST\AppBundle\Entity\Image $image
     *
     * @return Trick
     */
    public function setImage(\ST\AppBundle\Entity\Image $image = null)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return \ST\AppBundle\Entity\Image
     */
    public function getImage()
    {
        return $this->image;
    }
}
