<?php

namespace App\Entity;

/**
 * Marks translation entities that are narrowed to the request locale by {@see \App\Doctrine\OneLocaleFilter}.
 */
interface OneLocaleInterface
{
    public function getLocale(): ?string;
}
