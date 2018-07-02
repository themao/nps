<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * UrlRedirect
 *
 * @ORM\Entity()
 * @ORM\Table(name="url_redirect")
 */
class UrlRedirect
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(name="old_url", type="string", length=255)
     */
    private $oldUrl;

    /**
     * @var string
     * @ORM\Column(name="new_url", type="string", length=255, nullable=true)
     */
    private $newUrl;

    /**
     * @var string
     * @ORM\Column(name="referer", type="string", length=2048, nullable=true)
     */
    private $referer;

    /**
     * @var \DateTime
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime")
     */
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
