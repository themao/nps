<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Gedmo\Translatable\Translatable;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Page
 *
 * @ORM\Table(name="page")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PageRepository")
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false)
 */
class Page implements Translatable
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
     * @var string
     * @ORM\Column(name="showInquiryForm", type="boolean")
     */
    private $showInquiryForm;

    /**
     * @var \Application\Sonata\MediaBundle\Entity\Gallery
     *
     * @ORM\ManyToOne(
     *  targetEntity="Application\Sonata\MediaBundle\Entity\Gallery",
     *  cascade={"persist"},
     *  fetch="LAZY"
     * )
     */
    protected $gallery;

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
     * @return PageTranslation
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;
        return $this;
    }

    /**
     * @return string
     */
    public function getShowInquiryForm()
    {
        return $this->showInquiryForm;
    }

    /**
     * @param string $showInquiryForm
     * @return Page
     */
    public function setShowInquiryForm($showInquiryForm)
    {
        $this->showInquiryForm = $showInquiryForm;
        return $this;
    }

    /**
     * @return \Application\Sonata\MediaBundle\Entity\Gallery
     */
    public function getGallery()
    {
        return $this->gallery;
    }

    /**
     * @param \Application\Sonata\MediaBundle\Entity\Gallery $gallery
     * @return Page
     */
    public function setGallery($gallery)
    {
        $this->gallery = $gallery;
        return $this;
    }
}
