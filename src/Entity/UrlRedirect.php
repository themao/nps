<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

#[ORM\Entity]
#[ORM\Table(name: 'url_redirect')]
class UrlRedirect
{
    #[ORM\Id]
    #[ORM\Column(name: 'id', type: 'integer')]
    #[ORM\GeneratedValue(strategy: 'AUTO')]
    private $id;

    #[ORM\Column(name: 'old_url', type: 'string', length: 255)]
    private $oldUrl;

    #[ORM\Column(name: 'new_url', type: 'string', length: 255, nullable: true)]
    private $newUrl;

    #[ORM\Column(name: 'referer', type: 'string', length: 2048, nullable: true)]
    private $referer;

    #[Gedmo\Timestampable(on: 'create')]
    #[ORM\Column(type: 'datetime')]
    private $createdAt;

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
    public function getOldUrl()
    {
        return $this->oldUrl;
    }

    /**
     * @param string $oldUrl
     * @return UrlRedirect
     */
    public function setOldUrl($oldUrl)
    {
        $this->oldUrl = $oldUrl;
        return $this;
    }

    /**
     * @return string
     */
    public function getNewUrl()
    {
        return $this->newUrl;
    }

    /**
     * @param string $newUrl
     * @return UrlRedirect
     */
    public function setNewUrl($newUrl)
    {
        $this->newUrl = $newUrl;
        return $this;
    }

    /**
     * @return string
     */
    public function getReferer()
    {
        return $this->referer;
    }

    /**
     * @param string $referer
     * @return UrlRedirect
     */
    public function setReferer($referer)
    {
        $this->referer = $referer;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTime $createdAt
     * @return UrlRedirect
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
        return $this;
    }
}
