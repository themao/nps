<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Sonata\MediaBundle\Entity\BaseGallery;

#[ORM\Entity]
#[ORM\Table(name: 'media__gallery')]
class Gallery extends BaseGallery
{
    #[ORM\Id]
    #[ORM\Column(type: 'integer')]
    #[ORM\GeneratedValue]
    protected ?int $id = null;

    #[ORM\OneToMany(mappedBy: 'gallery', targetEntity: GalleryItem::class, cascade: ['persist'], orphanRemoval: true)]
    #[ORM\OrderBy(['position' => 'ASC'])]
    protected \Doctrine\Common\Collections\Collection $galleryItems;

    public function getId(): ?int
    {
        return $this->id;
    }
}
