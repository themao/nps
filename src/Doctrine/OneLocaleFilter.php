<?php

namespace App\Doctrine;

use App\Entity\OneLocaleInterface;
use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\Query\Filter\SQLFilter;

/**
 * Restricts translation entities to the current request locale (ported from A2lix I18nDoctrineBundle).
 */
class OneLocaleFilter extends SQLFilter
{
    public function addFilterConstraint(ClassMetadata $targetEntity, $targetTableAlias): string
    {
        if (!$targetEntity->reflClass->implementsInterface(OneLocaleInterface::class) || !$this->hasParameter('locale')) {
            return '';
        }

        return $targetTableAlias.'.locale = '.$this->getParameter('locale');
    }
}
