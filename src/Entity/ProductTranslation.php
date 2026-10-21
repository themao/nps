<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'product_translations')]
#[ORM\UniqueConstraint(columns: ['translatable_id', 'locale'])]
class ProductTranslation implements OneLocaleInterface
{
    use TranslationTrait;

    #[ORM\ManyToOne(targetEntity: Product::class, inversedBy: 'translations')]
    #[ORM\JoinColumn(name: 'translatable_id', referencedColumnName: 'id', onDelete: 'CASCADE')]
    protected $translatable;

    #[ORM\Column(name: 'title', type: 'string', length: 255)]
    private $title;

    #[ORM\Column(name: 'content', type: 'text', nullable: true)]
    private $content;

    #[ORM\Column(name: 'meta_description', type: 'string', length: 255, nullable: true)]
    private $metaDescription;

    #[ORM\Column(name: 'noindex', type: 'boolean', nullable: false)]
    private $noindex = false;

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return ProductTranslation
     */
    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param string $content
     * @return ProductTranslation
     */
    public function setContent($content)
    {
        $this->content = $content;
        return $this;
    }

    /**
     * @return string
     */
    public function getMetaDescription()
    {
        return $this->metaDescription;
    }

    /**
     * @param string $metaDescription
     * @return ProductTranslation
     */
    public function setMetaDescription($metaDescription)
    {
        $this->metaDescription = $metaDescription;
        return $this;
    }

    /**
     * @return boolean
     */ 
    public function getNoindex()
    {
        return $this->noindex;
    }

    /**
     * @param bool $noindex
     * @return ProductTranslation
     */ 
    public function setNoindex(bool $noindex)
    {
        $this->noindex = $noindex;
        return $this;
    }
}
