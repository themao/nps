<?php

namespace AppBundle\Entity;

use A2lix\I18nDoctrineBundle\Doctrine\Interfaces\OneLocaleInterface;
use A2lix\I18nDoctrineBundle\Doctrine\ORM\Util\Translation;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Translatable\Entity\MappedSuperclass\AbstractTranslation;

/**
 * @ORM\Entity
 * @ORM\Table(name="products_translations",
 *     uniqueConstraints={@ORM\UniqueConstraint(name="lookup_unique_idx", columns={
 *         "locale", "object_id", "field"
 *     })}
 * )
 */
class ProductsTranslation implements OneLocaleInterface
{
    use Translation;

    public function getId()
    {
        return $this->id;
    }

    /**
     * @var string
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return ProductsTranslation
     */
    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }
}
