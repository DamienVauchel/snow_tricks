<?php

namespace ST\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Category
 *
 * @ORM\Table(name="category")
 * @ORM\Entity(repositoryClass="ST\AppBundle\Repository\CategoryRepository")
 */
class Category
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
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="ST\AppBundle\Entity\Trick", mappedBy="category", cascade={"remove"})
     */
    private $tricks;

    /**
     * @var string
     *
     * @Gedmo\Slug(fields={"name"})
     * @ORM\Column(name="slug", type="string", length=255, unique=true)
     */
    private $slug;

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
     * Set name
     *
     * @param string $name
     *
     * @return Category
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->tricks = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add trick
     *
     * @param \ST\AppBundle\Entity\Trick $trick
     *
     * @return Category
     */
    public function addTrick(\ST\AppBundle\Entity\Trick $trick)
    {
        $this->tricks[] = $trick;

        return $this;
    }

    /**
     * Remove trick
     *
     * @param \ST\AppBundle\Entity\Trick $trick
     */
    public function removeTrick(\ST\AppBundle\Entity\Trick $trick)
    {
        $this->tricks->removeElement($trick);
    }

    /**
     * Get tricks
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTricks()
    {
        return $this->tricks;
    }

    /**
     * Set slug
     *
     * @param string $slug
     *
     * @return Category
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }
}
