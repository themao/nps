<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Gedmo\Mapping\Annotation as Gedmo;
use App\Repository\ProductRepository;

#[ORM\Table(name: 'product')]
#[ORM\Entity(repositoryClass: ProductRepository::class)]
#[Gedmo\SoftDeleteable(fieldName: 'deletedAt', timeAware: false)]
class Product
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

    /**
     * @var Gallery
     */
    #[ORM\ManyToOne(targetEntity: Gallery::class, cascade: ['persist'], fetch: 'LAZY')]
    protected $pictures;

    #[ORM\OneToMany(mappedBy: 'translatable', targetEntity: ProductTranslation::class, indexBy: 'locale', cascade: ['persist', 'remove'])]
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
     * @return \App\Entity\Gallery
     */
    public function getPictures()
    {
        return $this->pictures;
    }

    /**
     * @param \App\Entity\Gallery $pictures
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
