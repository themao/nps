<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

/**
 * Replacement for the abandoned A2lix I18nDoctrineBundle Translatable trait.
 * The using entity maps $translations as OneToMany(mappedBy: 'translatable', indexBy: 'locale').
 */
trait TranslatableTrait
{
    public function getTranslations(): Collection
    {
        return $this->translations ??= new ArrayCollection();
    }

    public function setTranslations(Collection $translations): static
    {
        $this->translations = $translations;

        return $this;
    }

    public function addTranslation($translation): static
    {
        $this->getTranslations()->set($translation->getLocale(), $translation);
        $translation->setTranslatable($this);

        return $this;
    }

    public function removeTranslation($translation): void
    {
        $this->getTranslations()->removeElement($translation);
    }

    public static function getTranslationEntityClass(): string
    {
        return __CLASS__.'Translation';
    }

    public function getCurrentTranslation()
    {
        return $this->getTranslations()->first() ?: null;
    }

    public function __call($method, $args)
    {
        $method = str_starts_with($method, 'get') ? $method : 'get'.ucfirst($method);

        return ($translation = $this->getCurrentTranslation()) ? $translation->$method() : '';
    }
}
