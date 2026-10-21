<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Sonata\UserBundle\Entity\BaseUser;

/**
 * Admin user. The table still carries the FOSUserBundle/Sonata User 3 columns; only the ones Sonata User 5 uses are mapped.
 */
#[ORM\Entity]
#[ORM\Table(name: 'fos_user_user')]
class User extends BaseUser
{
    #[ORM\Id]
    #[ORM\Column(type: 'integer')]
    #[ORM\GeneratedValue]
    protected $id;
}
