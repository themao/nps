<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Sonata\MediaBundle\Entity\BaseGalleryItem;
use Sonata\MediaBundle\Model\GalleryInterface;
use Sonata\MediaBundle\Model\MediaInterface;

/**
 * Formerly GalleryHasMedia (Sonata Media 3); the table name is kept.
 */
#[ORM\Entity]
#[ORM\Table(name: 'media__gallery_media')]
class GalleryItem extends BaseGalleryItem
{
    #[ORM\Id]
    #[ORM\Column(type: 'integer')]
    #[ORM\GeneratedValue]
    protected ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Gallery::class, inversedBy: 'galleryItems')]
    #[ORM\JoinColumn(name: 'gallery_id')]
    protected ?GalleryInterface $gallery = null;

    #[ORM\ManyToOne(targetEntity: Media::class, inversedBy: 'galleryItems', cascade: ['persist'])]
    #[ORM\JoinColumn(name: 'media_id')]
    protected ?MediaInterface $media = null;

    public function getId(): ?int
    {
        return $this->id;
    }
}
