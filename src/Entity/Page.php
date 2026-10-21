<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Gedmo\Mapping\Annotation as Gedmo;
use App\Repository\PageRepository;

#[ORM\Table(name: 'page')]
#[ORM\Entity(repositoryClass: PageRepository::class)]
#[Gedmo\SoftDeleteable(fieldName: 'deletedAt', timeAware: false)]
class Page
{
    use TimestampableEntity;
    use SoftDeleteableEntity;
    use TranslatableTrait;

    #[ORM\Id]
    #[ORM\Column(name: 'id', type: 'integer')]
    #[ORM\GeneratedValue(strategy: 'AUTO')]
    private $id;

    #[ORM\Column(name: 'slug', type: 'string', length: 30)]
    private $slug;

    #[ORM\Column(name: 'showInquiryForm', type: 'boolean')]
    private $showInquiryForm;

    /**
     * @var Gallery
     */
    #[ORM\ManyToOne(targetEntity: Gallery::class, cascade: ['persist'], fetch: 'LAZY')]
    protected $gallery;

    #[ORM\OneToMany(mappedBy: 'translatable', targetEntity: PageTranslation::class, indexBy: 'locale', cascade: ['persist', 'remove'])]
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
     * @return \App\Entity\Gallery
     */
    public function getGallery()
    {
        return $this->gallery;
    }

    /**
     * @param \App\Entity\Gallery $gallery
     * @return Page
     */
    public function setGallery($gallery)
    {
        $this->gallery = $gallery;
        return $this;
    }
}
