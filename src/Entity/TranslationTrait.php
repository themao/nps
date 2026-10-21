<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Replacement for the abandoned A2lix I18nDoctrineBundle Translation trait.
 * The using entity maps $translatable as ManyToOne(inversedBy: 'translations') on column translatable_id.
 */
trait TranslationTrait
{
    #[ORM\Id]
    #[ORM\Column(type: 'integer')]
    #[ORM\GeneratedValue(strategy: 'AUTO')]
    protected $id;

    #[ORM\Column(length: 10)]
    protected $locale;

    public function getId()
    {
        return $this->id;
    }

    public function getTranslatable()
    {
        return $this->translatable;
    }

    public function setTranslatable($translatable): static
    {
        $this->translatable = $translatable;

        return $this;
    }

    public function getLocale(): ?string
    {
        return $this->locale;
    }

    public function setLocale($locale): static
    {
        $this->locale = $locale;

        return $this;
    }
}
