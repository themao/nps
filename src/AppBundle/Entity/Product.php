<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Gedmo\Translatable\Translatable;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Product
 *
 * @ORM\Table(name="product")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ProductRepository")
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false)
 */
class Product implements Translatable
{
    use TimestampableEntity;
    use SoftDeleteableEntity;
    use \A2lix\I18nDoctrineBundle\Doctrine\ORM\Util\Translatable;

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
     * @ORM\Column(name="slug", type="string", length=30)
     */
    private $slug;

    /**
     * @var \Application\Sonata\MediaBundle\Entity\Gallery
     *
     * @ORM\ManyToOne(
     *  targetEntity="Application\Sonata\MediaBundle\Entity\Gallery",
     *  cascade={"persist"},
     *  fetch="LAZY"
     * )
     */
    protected $pictures;

    protected $translations;

    public function __construct()
    {
        $this->translations = new ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * @param string $slug
     * @return Product
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;
        return $this;
    }

    /**
     * @return \Application\Sonata\MediaBundle\Entity\Media
     */
    public function getPictures()
    {
        return $this->pictures;
    }

    /**
     * @param \Application\Sonata\MediaBundle\Entity\Media $pictures
     * @return Product
     */
    public function setPictures($pictures)
    {
        $this->pictures = $pictures;
        return $this;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->getCurrentTranslation() ? $this->getCurrentTranslation()->getTitle() : '';
    }
}
